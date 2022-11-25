<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccomplishmentType extends Model
{
    public $table = 'accomplishment_type';

    public $timestamps = false;

    protected $attributes = [
        'id' => null,
    ];
}
