<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function comfortCategories()
    {
        return $this->belongsToMany(ComfortCategory::class, 'position_comfort_category');
    }
}
