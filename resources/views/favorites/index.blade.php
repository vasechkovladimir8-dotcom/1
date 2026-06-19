@extends('layouts.main')

@section('title', 'Избранное')

@section('content')
<div class="fade-in-up">
    <h1 class="section-title">
        <i class="bi bi-heart-fill me-2"></i>Избранные растения
    </h1>

    @forelse($favorites as $favorite)
        @php $plant = $favorite->plant; @endphp
        <div class="col-md-3 mb-4 d-inline-block align-top" style="width: 23%; margin-right: 2%;">
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
                    <div class="mt-3 d-flex gap-2">
                        <a href="{{ route('plants.show', $plant->id) }}" class="btn btn-outline-success btn-sm flex-grow-1">
                            <i class="bi bi-eye"></i>
                        </a>
                        <form action="{{ route('favorites.toggle', $plant->id) }}" method="POST" class="flex-grow-1">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-2"></i>В избранном пока нет растений. 
            <a href="{{ route('plants.index') }}" class="alert-link">Перейти в каталог</a>
        </div>
    @endforelse

    @if($favorites->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $favorites->links() }}
        </div>
    @endif
</div>
@endsection