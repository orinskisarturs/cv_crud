<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationProgress extends Model
{
    public $table = 'education_progress';

    public $timestamps = false;

    protected $attributes = [
        'id' => null,
    ];
}
