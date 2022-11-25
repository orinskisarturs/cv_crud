<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    public $table = 'job_type';

    public $timestamps = false;

    protected $attributes = [
        'id' => null,
    ];
}
