@extends('layouts.app')

@section('title', 'Главная - Справочник комнатных растений')

@section('content')
<!-- Hero секция -->
<div class="hero-section fade-in-up">
    <div class="container">
        <div class="hero-content text-center">
            <h1 class="display-3 fw-bold mb-3">
                <i class="bi bi-flower1"></i> Мир комнатных растений
            </h1>
            <p class="lead mb-4">Откройте для себя удивительный мир зелени в вашем доме</p>
            <a href="{{ route('plants.index') }}" class="btn btn-light btn-lg px-5">
                <i class="bi bi-grid me-2"></i>Перейти к каталогу
            </a>
        </div>
    </div>
</div>

<!-- Категории -->
<div class="fade-in-up">
    <h2 class="section-title">Категории растений</h2>
    <div class="row g-4 mb-5">
        @foreach($categories as $category)
            <div class="col-md-4">
                <a href="{{ route('categories.show', $category->id) }}" class="text-decoration-none">
                    <div class="category-card">
                        <div class="category-icon">
                            @if($category->name === 'Кактусы')
                                <i class="bi bi-flower2"></i>
                            @elseif($category->name === 'Суккуленты')
                                <i class="bi bi-tree"></i>
                            @elseif($category->name === 'Папоротники')
                                <i class="bi bi-tree-fill"></i>
                            @elseif($category->name === 'Цветущие')
                                <i class="bi bi-flower1"></i>
                            @elseif($category->name === 'Декоративно-лиственные')
                                <i class="bi bi-leaves"></i>
                            @elseif($category->name === 'Пальмы')
                                <i class="bi bi-tree"></i>
                            @else
                                <i class="bi bi-flower1"></i>
                            @endif
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--primary-green);">{{ $category->name }}</h5>
                        <p class="text-muted mb-0">{{ $category->plants_count }} растений</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

<!-- Последние добавленные растения -->
<div class="fade-in-up">
    <h2 class="section-title">Последние добавленные</h2>
    <div class="row g-4">
        @foreach($latestPlants as $plant)
            <div class="col-md-4">
                <div class="plant-card">
                    @if($plant->image)
                        <img src="{{ asset('storage/' . $plant->image) }}" class="card-img-top plant-image" alt="{{ $plant->name }}">
                    @else
                        <div class="card-img-top plant-image bg-light d-flex align-items-center justify-content-center">
                            <i class="bi bi-flower1" style="font-size: 4rem; color: var(--accent-green); opacity: 0.3;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $plant->name }}</h5>
                        <p class="card-text fst-italic small">{{ $plant->latin_name }}</p>
                        <span class="badge badge-category">{{ $plant->category->name }}</span>
                        <div class="mt-3">
                            <a href="{{ route('plants.show', $plant->id) }}" class="btn btn-outline-success w-100">
                                <i class="bi bi-eye me-2"></i>Подробнее
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection