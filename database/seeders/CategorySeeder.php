<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Кактусы',
            'Суккуленты',
            'Папоротники',
            'Цветущие',
            'Декоративно-лиственные',
            'Пальмы',
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}