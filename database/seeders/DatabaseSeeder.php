<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $cvId = DB::table('cv')->insertGetId([
            'name' => 'Artūrs',
            'surname' => 'Orinskis',
            'phone' => '28315445',
            'email' => 'orinskis.a@gmail.com',
        ]);

        $workplaceId = DB::table('workplace')->insertGetId([
            'name' => 'SIA "Darba vieta"',
            'cv_id' => $cvId,
        ]);

        $jobTypeId = DB::table('job_type')->insertGetId([
            'name' => 'Pilna slodze',
        ]);
        $jobTypeTwoId = DB::table('job_type')->insertGetId([
            'name' => 'Pusslodze',
        ]);

        $workplacePositionTwoId = DB::table('workplace_position')->insertGetId([
            'name' => 'Programmētājs',
            'employment_length' => 18,
            'workplace_id' => $workplaceId,
            'job_type_id' => $jobTypeId,
        ]);

        $accomplishmentTypeId = DB::table('accomplishment_type')->insertGetId([
            'name' => 'Prasme',
        ]);

        $accomplishmentTypeTwoId = DB::table('accomplishment_type')->insertGetId([
            'name' => 'Sasniegums',
        ]);

        DB::table('workplace_position_accomplishment')->insertGetId([
            'name' => 'Agile',
            'description' => 'Darbs vairākos projektos izmantotjot Agile izstrādes metodi',
            'workplace_position_id' => $workplacePositionTwoId,
            'accomplishment_type_id' => $accomplishmentTypeId
        ]);
        DB::table('workplace_position_accomplishment')->insertGetId([
            'name' => 'Gada labākais programmētājs',
            'workplace_position_id' => $workplacePositionTwoId,
            'accomplishment_type_id' => $accomplishmentTypeTwoId
        ]);

        $workplacePositionOneId = DB::table('workplace_position')->insertGetId([
            'name' => 'Jaunākais programmētājs',
            'employment_length' => 12,
            'workplace_id' => $workplaceId,
            'job_type_id' => $jobTypeId,
        ]);

        DB::table('workplace_position_accomplishment')->insertGetId([
            'name' => 'Docker',
            'description' => 'Iegūtas prasmes izveidot jaunas docker instances',
            'workplace_position_id' => $workplacePositionOneId,
            'accomplishment_type_id' => $accomplishmentTypeId,
        ]);

        $workplaceTwoId = DB::table('workplace')->insertGetId([
            'name' => 'SIA "Darba vieta 2"',
            'cv_id' => $cvId,
        ]);

        DB::table('workplace_position')->insertGetId([
            'name' => 'Programmētājs',
            'employment_length' => 24,
            'workplace_id' => $workplaceTwoId,
            'job_type_id' => $jobTypeTwoId,
        ]);

        $institutionId = DB::table('educational_institution')->insertGetId([
            'name' => "Latvijas Universitāte",
            'faculty' => 'Datorikas fakultāte',
            'cv_id' => $cvId,
        ]);

        DB::table('education_progress')->insertGetId([
            'name' => 'Iesākts',
        ]);
        $educationProgressTwoId = DB::table('education_progress')->insertGetId([
            'name' => 'Pabeigts',
        ]);

        $educationId = DB::table('education')->insertGetId([
            'educational_level' => 'Bakalaura grāds',
            'field_of_study' => 'Programmēšana',
            'education_progress_id' => $educationProgressTwoId,
            'time_spent_in_studies' => 48,
            'educational_institution_id' => $institutionId,
        ]);

        $countryId = DB::table('country')->insertGetId([
            'name' => 'Latvija',
        ]);
        DB::table('country')->insertGetId([
            'name' => 'Lietuva',
        ]);
        DB::table('country')->insertGetId([
            'name' => 'Igaunija',
        ]);

        DB::table('address')->insertGetId([
            'cv_id' => $cvId,
            'country_id' => $countryId,
            'index' => 'LV-1004',
            'city' => 'Rīga',
            'street' => 'Garozes iela',
            'building' => '17',
        ]);
    }
}
