<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PlantController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Маршруты административной панели
|--------------------------------------------------------------------------
|
| Все маршруты здесь имеют префикс /admin и защищены middleware 'admin'.
| Доступны только пользователям с ролью администратора.
|
*/

// Главная админки — статистика
Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

// CRUD растений
Route::resource('plants', PlantController::class)->names('admin.plants');

// CRUD категорий
Route::resource('categories', CategoryController::class)->names('admin.categories');

// Пользователи
Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
Route::get('users/{id}', [UserController::class, 'show'])->name('admin.users.show');
Route::get('users/{id}/edit-role', [UserController::class, 'editRole'])->name('admin.users.edit-role');
Route::post('users/{id}/update-role', [UserController::class, 'updateRole'])->name('admin.users.update-role');
Route::delete('users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');