<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['license_plate', 'car_model_id', 'driver_id'];

    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
