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

    /**
     * Категория растения
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Избранные (связь с пользователями через таблицу favorites)
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Заметки пользователей
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Связь M:N с характеристиками
     */
    public function characteristics()
    {
        return $this->belongsToMany(Characteristic::class, 'characteristic_plant');
    }

    /**
     * Дополнительные изображения растения
     */
    public function images()
    {
        return $this->hasMany(PlantImage::class);
    }

    /**
     * Получить все изображения растения (основное + дополнительные)
     */
    public function getAllImagesAttribute()
    {
        $allImages = [];
        
        // Основное изображение
        if ($this->image) {
            $allImages[] = [
                'path' => $this->image,
                'is_main' => true,
                'sort_order' => -1,
            ];
        }
        
        // Дополнительные изображения
        foreach ($this->images->sortBy('sort_order') as $image) {
            $allImages[] = [
                'path' => $image->path,
                'is_main' => false,
                'sort_order' => $image->sort_order,
            ];
        }
        
        return $allImages;
    }
}