<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'latin_name',
        'description',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    // Связь M:N с характеристиками
    public function characteristics()
    {
        return $this->belongsToMany(Characteristic::class, 'characteristic_plant');
    }
}