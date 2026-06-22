@extends('admin.layouts.app')

@section('title', 'Главная')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Добро пожаловать, {{ auth()->user()->name }}!</h1>
        <p class="text-muted mb-0">Обзор состояния справочника</p>
    </div>
</div>

<!-- Статистика -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stat-card text-white" style="background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Растений в каталоге</div>
                    <div class="stat-number">{{ $plantsCount }}</div>
                </div>
                <i class="bi bi-flower1 stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card text-white" style="background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Категорий</div>
                    <div class="stat-number">{{ $categoriesCount }}</div>
                </div>
                <i class="bi bi-folder stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card text-white" style="background: linear-gradient(135deg, #6f42c1 0%, #d63384 100%);">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Пользователей</div>
                    <div class="stat-number">{{ $usersCount }}</div>
                </div>
                <i class="bi bi-people stat-icon"></i>
            </div>
        </div>
    </div>
</div>

<!-- Быстрые действия -->
<div class="card table-card">
    <div class="card-body">
        <h5 class="card-title mb-3">
            <i class="bi bi-lightning-charge me-2"></i>Быстрые действия
        </h5>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.plants.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Добавить растение
            </a>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary">
                <i class="bi bi-folder-plus me-2"></i>Добавить категорию
            </a>
            <a href="{{ route('admin.plants.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-list-ul me-2"></i>Все растения
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-people me-2"></i>Все пользователи
            </a>
        </div>
    </div>
</div>
@endsection