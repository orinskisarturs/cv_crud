<?php

namespace App\Http\Controllers;

use App\Models\AccomplishmentType;
use App\Models\Address;
use App\Models\Cv;
use App\Models\Education;
use App\Models\EducationalInstitution;
use App\Models\EducationProgress;
use App\Models\JobType;
use App\Models\Workplace;
use App\Models\WorkplacePosition;
use App\Models\WorkplacePositionAccomplishment;
use Illuminate\Http\Request;

class CvController extends Controller
{
    private function relations()
    {
        return [
            'workplaces' => [
                'workplace_positions' => [
                    'workplace_position_accomplishments'
                ],
            ],
            'educational_institutions' => [
                'educations',
            ],
            'address',
        ];
    }

    public function index()
    {
        return Cv::with(self::relations())->get();
    }

    public function show($id)
    {
        return Cv::with(self::relations())->find($id);
    }

    public function store(Request $request)
    {
        $submission = json_decode($request->getContent(), true);
        $cv = new Cv($submission);
        $cv->save();
        foreach ($submission['workplaces'] as $workplaceSubmitted) {
            $workplace = $cv->workplaces()->create($workplaceSubmitted);
            $cv->save();
            foreach ($workplaceSubmitted['workplace_positions'] as $workplacePositionSubmitted) {
                $workplacePosition = $workplace->workplace_positions()->create($workplacePositionSubmitted);
                $cv->save();
                foreach ($workplacePositionSubmitted['workplace_position_accomplishments'] as $accomplishmentSubmitted) {
                    $workplacePosition->workplace_position_accomplishments()->create($accomplishmentSubmitted);
                }
            }
        }
        foreach ($submission['educational_institutions'] as $institutionSubmitted) {
            $institution = $cv->educational_institutions()->create($institutionSubmitted);
            $cv->save();
            foreach ($institutionSubmitted['educations'] as $educationSubmitted) {
                $institution->educations()->create($educationSubmitted);
            }
        }
        $cv->address()->create($submission['address']);
        $cv->save();

        return self::show($cv->id);
    }

    private function updateRelation($child, $relation, $submission)
    {
        $childrenIds = $relation->pluck('id')->toArray();
        $submissionIds = array_column($submission, 'id');

        foreach ($childrenIds as $childId) {
            if (!in_array($childId, $submissionIds)) {
                call_user_func("$child::find", $childId)->delete();
            }
        }
        foreach ($submission as $submittedChild) {
            if (array_key_exists('id', $submittedChild)) {
                call_user_func("$child::find", $submittedChild['id'])->update($submittedChild);
            } else {
                $relation->create($submittedChild);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $submission = json_decode($request->getContent(), true);
        $cv = self::show($id);
        $cv->update($submission);
        $cv->address()->update($submission['address']);

        $workplaceIds = $cv->workplaces()->pluck('id')->toArray();
        $submittedWorkplaceIds = array_column($submission['workplaces'], 'id');

        foreach ($workplaceIds as $workplaceId) {
            if (!in_array($workplaceId, $submittedWorkplaceIds)) {
                Workplace::find($workplaceId)->delete();
            }
        }
        foreach ($submission['workplaces'] as $submittedWorkplace) {
            // Update workplace
            if (array_key_exists('id', $submittedWorkplace)) {
                Workplace::find($submittedWorkplace['id'])->update($submittedWorkplace);

                $positionIds = Workplace::find($submittedWorkplace['id'])->workplace_positions()->pluck('id')->toArray();
                $submittedPositionIds = array_column($submittedWorkplace['workplace_positions'], 'id');

                foreach ($positionIds as $positionId) {
                    if (!in_array($positionId, $submittedPositionIds)) {
                        WorkplacePosition::find($positionId)->delete();
                    }
                }

                foreach ($submittedWorkplace['workplace_positions'] as $submittedPosition) {
                    if (array_key_exists('id', $submittedPosition)) {
                        // Update position

                        WorkplacePosition::find($submittedPosition['id'])->update($submittedPosition);

                        $accomplishmentIds = WorkplacePosition::find($submittedPosition['id'])->workplace_position_accomplishments()->pluck('id')->toArray();
                        $submittedAccomplishmentIds = array_column($submittedPosition['workplace_position_accomplishments'], 'id');

                        foreach ($accomplishmentIds as $accomplishmentId) {
                            if (!in_array($accomplishmentId, $submittedAccomplishmentIds)) {
                                WorkplacePositionAccomplishment::find($accomplishmentId)->delete();
                            }
                        }

                        foreach ($submittedPosition['workplace_position_accomplishments'] as $submittedAccomplishment) {
                            if (array_key_exists('id', $submittedAccomplishment)) {
                                // Update accomplishment
                                WorkplacePositionAccomplishment::find($submittedAccomplishment['id'])->update($submittedAccomplishment);
                            } else {
                                // Create accomplishment
                                WorkplacePosition::find($submittedPosition['id'])->workplace_position_accomplishments()->create($submittedAccomplishment);
                            }
                        }
                    } else {
                        // Create position
                        $positionCreated = Workplace::find($submittedWorkplace['id'])->workplace_positions()->create($submittedPosition);

                        foreach ($submittedPosition['workplace_position_accomplishments'] as $accomplishment) {
                            $positionCreated->workplace_position_accomplishments()->create($accomplishment);
                        }
                    }
                }
            } else {
                // Create workplace
                $workplaceCreated = $cv->workplaces()->create($submittedWorkplace);

                foreach ($submittedWorkplace['workplace_positions'] as $position) {
                    $positionCreated = $workplaceCreated->workplace_submissions()->create($position);
                    foreach ($position['workplace_position_accomplishments'] as $accomplishment) {
                        $positionCreated->workplace_position_accomplishments()->create($position);
                    }
                }
            }
        }

        $workplaceIds = $cv->workplaces()->pluck('id')->toArray();
        $submittedWorkplaceIds = array_column($submission['workplaces'], 'id');

        foreach ($workplaceIds as $workplaceId) {
            if (!in_array($workplaceId, $submittedWorkplaceIds)) {
                Workplace::find($workplaceId)->delete();
            }
        }
        foreach ($submission['educational_institutions'] as $submittedInstitution) {
            // Update institution
            if (array_key_exists('id', $submittedInstitution)) {
                EducationalInstitution::find($submittedInstitution['id'])->update($submittedInstitution);

                $educationsIds = EducationalInstitution::find($submittedInstitution['id'])->educations()->pluck('id')->toArray();
                $submittedEducationIds = array_column($submittedInstitution['educations'], 'id');

                foreach ($educationsIds as $educationId) {
                    if (!in_array($educationId, $submittedEducationIds)) {
                        Education::find($educationId)->delete();
                    }
                }

                foreach ($submittedInstitution['educations'] as $submittedEducation) {
                    if (array_key_exists('id', $submittedEducation)) {
                        // Update education
                        Education::find($submittedEducation['id'])->update($submittedEducation);
                    } else {
                        // Create education
                        EducationalInstitution::find($submittedInstitution['id'])->educations()->create($submittedEducation);
                    }
                }
            } else {
                // Create institution
                $institutionCreated = $cv->educational_institutions()->create($submittedInstitution);

                foreach ($submittedInstitution['educations'] as $education) {
                    $institutionCreated->educations()->create($education);
                }
            }
        }

        $cv->save();
        return self::show($id);
    }

    public function destroy($id)
    {
        Cv::destroy($id);
    }
}
