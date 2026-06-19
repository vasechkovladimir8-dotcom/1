@extends('layouts.main')

@section('title', 'Личный кабинет')

@section('content')
<div class="fade-in-up">
    <h1 class="section-title">
        <i class="bi bi-speedometer2 me-2"></i>Личный кабинет
    </h1>

    <div class="row g-4">
        <!-- Приветствие -->
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h3 class="mb-3">Добро пожаловать, {{ Auth::user()->name }}!</h3>
                    <p class="text-muted mb-0">Здесь вы можете управлять избранными растениями и заметками.</p>
                </div>
            </div>
        </div>

        <!-- Статистика -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body text-center p-4">
                    <i class="bi bi-heart-fill" style="font-size: 3rem; color: #dc3545;"></i>
                    <h2 class="mt-3">{{ Auth::user()->favorites()->count() }}</h2>
                    <p class="text-muted mb-0">Избранных растений</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body text-center p-4">
                    <i class="bi bi-journal-text" style="font-size: 3rem; color: var(--accent-green);"></i>
                    <h2 class="mt-3">{{ Auth::user()->notes()->count() }}</h2>
                    <p class="text-muted mb-0">Заметок</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body text-center p-4">
                    <i class="bi bi-person-circle" style="font-size: 3rem; color: var(--primary-green);"></i>
                    <h5 class="mt-3">{{ Auth::user()->name }}</h5>
                    <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Быстрые действия -->
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h4 class="mb-3">Быстрые действия</h4>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('plants.index') }}" class="btn btn-outline-success">
                            <i class="bi bi-grid me-2"></i>Перейти в каталог
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-success">
                            <i class="bi bi-person me-2"></i>Редактировать профиль
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection