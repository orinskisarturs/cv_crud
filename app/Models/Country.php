<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $table = 'country';

    public $timestamps = false;

    protected $attributes = [
        'id' => null,
    ];
}
