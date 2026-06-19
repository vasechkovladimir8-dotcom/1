@extends('layouts.app')

@section('title', $category->name . ' - Справочник растений')

@section('content')
<div class="fade-in-up">
    <!-- Хлебные крошки -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <h1 class="section-title">{{ $category->name }}</h1>

    <div class="row g-4">
        @forelse($category->plants as $plant)
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
                    <i class="bi bi-info-circle me-2"></i>В этой категории пока нет растений.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        <a href="{{ route('home') }}" class="btn btn-outline-success">
            <i class="bi bi-arrow-left me-2"></i>На главную
        </a>
    </div>
</div>
@endsection