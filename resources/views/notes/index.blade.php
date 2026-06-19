@extends('layouts.main')

@section('title', 'Мои заметки')

@section('content')
<div class="fade-in-up">
    <h1 class="section-title">
        <i class="bi bi-journal-text me-2"></i>Мои заметки
    </h1>

    @forelse($notes as $note)
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 15px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="mb-0">
                        <a href="{{ route('plants.show', $note->plant->id) }}" class="text-decoration-none" style="color: var(--primary-green);">
                            <i class="bi bi-flower1 me-2"></i>{{ $note->plant->name }}
                        </a>
                    </h5>
                    <small class="text-muted">
                        <i class="bi bi-clock me-1"></i>{{ $note->created_at->format('d.m.Y H:i') }}
                    </small>
                </div>
                <p class="mb-3">{{ $note->content }}</p>
                <div class="d-flex gap-2">
                    <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i>Редактировать
                    </a>
                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('Удалить заметку?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash me-1"></i>Удалить
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-2"></i>У вас пока нет заметок. 
            <a href="{{ route('plants.index') }}" class="alert-link">Перейти в каталог</a>
        </div>
    @endforelse

    @if($notes->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $notes->links() }}
        </div>
    @endif
</div>
@endsection