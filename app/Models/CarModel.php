<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $fillable = ['name', 'comfort_category_id'];

    public function comfortCategory()
    {
        return $this->belongsTo(ComfortCategory::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
