<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkplacePositionAccomplishment extends Model
{
    public $table = 'workplace_position_accomplishment';

    public $timestamps = false;

    protected $attributes = [
        'name' => null,
        'description' => null,
    ];

    protected $fillable = [
        'name',
        'description',
        'accomplishment_type_id',
    ];

    public function accomplishment_type()
    {
        return $this->hasOne(AccomplishmentType::class);
    }
}
