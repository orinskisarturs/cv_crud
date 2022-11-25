<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkplacePosition extends Model
{
    public $table = 'workplace_position';

    public $timestamps = false;

    protected $attributes = [
        'name' => null,
        'employment_length' => null,
    ];

    protected $fillable = [
        'name',
        'employment_length',
        'job_type_id',
    ];

    public function job_type()
    {
        return $this->hasOne(JobType::class);
    }

    public function workplace_position_accomplishments()
    {
        return $this->hasMany(WorkplacePositionAccomplishment::class);
    }
}
