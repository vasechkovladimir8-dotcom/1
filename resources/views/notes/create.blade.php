@extends('layouts.main')

@section('title', 'Новая заметка')

@section('content')
<div class="fade-in-up">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{ route('plants.index') }}">Каталог</a></li>
            <li class="breadcrumb-item"><a href="{{ route('plants.show', $plant->id) }}">{{ $plant->name }}</a></li>
            <li class="breadcrumb-item active">Новая заметка</li>
        </ol>
    </nav>

    <h1 class="section-title">
        <i class="bi bi-journal-plus me-2"></i>Новая заметка к растению «{{ $plant->name }}»
    </h1>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-4">
            <form action="{{ route('notes.store', $plant->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="content" class="form-label fw-semibold">Текст заметки</label>
                    <textarea name="content" id="content" rows="6" class="form-control @error('content') is-invalid @enderror" 
                              placeholder="Напишите ваши наблюдения об этом растении...">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-2"></i>Сохранить
                    </button>
                    <a href="{{ route('plants.show', $plant->id) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-2"></i>Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection