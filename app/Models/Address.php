<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $table = 'address';

    public $timestamps = false;

    protected $attributes = [
        'index' => null,
        'city' => null,
        'street' => null,
        'parish' => null,
        'village' => null,
        'building' => null,
    ];

    protected $fillable = [
        'index',
        'city',
        'street',
        'parish',
        'village',
        'building',
        'country_id',
    ];

    public function country()
    {
        return $this->hasOne(Country::class);
    }
}
