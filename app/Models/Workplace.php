<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workplace extends Model
{
    public $table = 'workplace';

    public $timestamps = false;

    protected $attributes = [
        'name' => null,
    ];

    protected $fillable = [
        'name',
    ];

    public function cv()
    {
        return $this->belongsTo(Cv::class)->withDefault(function () {
            return new Workplace();
        });
    }

    public function workplace_positions()
    {
        return $this->hasMany(WorkplacePosition::class);
    }
}
