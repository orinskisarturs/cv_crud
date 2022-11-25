<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    public $table = 'cv';

    public $timestamps = false;

    protected $attributes = [
        'name' => null,
        'surname' => null,
        'phone' => null,
        'email' => null,
    ];

    protected $fillable = [
        'name',
        'surname',
        'phone',
        'email',
    ];

    public function workplaces()
    {
        return $this->hasMany(Workplace::class);
    }

    public function educational_institutions()
    {
        return $this->hasMany(EducationalInstitution::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
