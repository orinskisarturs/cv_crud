<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationalInstitution extends Model
{
    public $table = 'educational_institution';

    public $timestamps = false;

    protected $attributes = [
        'name' => null,
        'faculty' => null,
    ];

    protected $fillable = [
        'name',
        'faculty',
    ];

    public function educations()
    {
        return $this->hasMany(Education::class);
    }
}
