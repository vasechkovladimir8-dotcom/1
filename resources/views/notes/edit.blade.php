@extends('layouts.main')

@section('title', 'Редактирование заметки')

@section('content')
<div class="fade-in-up">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{ route('notes.index') }}">Мои заметки</a></li>
            <li class="breadcrumb-item active">Редактирование</li>
        </ol>
    </nav>

    <h1 class="section-title">
        <i class="bi bi-pencil me-2"></i>Редактирование заметки
    </h1>

    <div class="card border-0 shadow-sm mb-3" style="border-radius: 15px;">
        <div class="card-body">
            <p class="text-muted mb-0">
                <i class="bi bi-flower1 me-2"></i>
                Растение: <strong>{{ $note->plant->name }}</strong>
            </p>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-4">
            <form action="{{ route('notes.update', $note->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="content" class="form-label fw-semibold">Текст заметки</label>
                    <textarea name="content" id="content" rows="6" class="form-control @error('content') is-invalid @enderror">{{ old('content', $note->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-2"></i>Сохранить изменения
                    </button>
                    <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-2"></i>Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection