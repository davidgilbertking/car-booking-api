<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComfortCategory extends Model
{
    protected $fillable = ['name'];

    public function carModels()
    {
        return $this->hasMany(CarModel::class);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'position_comfort_category');
    }
}
