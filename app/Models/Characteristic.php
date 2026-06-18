<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value'];

    // Связь M:N с растениями
    public function plants()
    {
        return $this->belongsToMany(Plant::class, 'characteristic_plant');
    }
}