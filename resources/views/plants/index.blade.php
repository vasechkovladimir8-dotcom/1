@extends('layouts.main')

@section('title', 'Каталог растений')

@section('content')
<div class="fade-in-up">
    <h1 class="section-title">Каталог комнатных растений</h1>

    <!-- Поиск и фильтрация -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('plants.index') }}">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-search me-2"></i>Поиск
                        </label>
                        <input type="text" name="search" class="form-control form-control-lg" 
                               placeholder="Введите название растения..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-filter me-2"></i>Категория
                        </label>
                        <select name="category" class="form-select form-select-lg">
                            <option value="">Все категории</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="bi bi-search me-2"></i>Найти
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Список растений -->
    <div class="row g-4">
        @forelse($plants as $plant)
            <div class="col-md-3">
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
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i>Растения не найдены. Попробуйте изменить параметры поиска.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Пагинация -->
    @if($plants->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $plants->links() }}
        </div>
    @endif
</div>
@endsection