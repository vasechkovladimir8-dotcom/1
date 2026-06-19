<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\CategoryController;

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Публичный каталог растений
Route::get('/plants', [PlantController::class, 'index'])->name('plants.index');
Route::get('/plants/{id}', [PlantController::class, 'show'])->name('plants.show');

// Категории
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');