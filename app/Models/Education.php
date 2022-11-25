<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    public $table = 'education';

    public $timestamps = false;

    protected $attributes = [
        'educational_level' => null,
        'time_spent_in_studies' => null,
        'field_of_study' => null,
    ];

    protected $fillable = [
        'educational_level',
        'time_spent_in_studies',
        'field_of_study',
        'education_progress_id',
    ];

    public function education_progress()
    {
        return $this->hasOne(EducationProgress::class);
    }
}
