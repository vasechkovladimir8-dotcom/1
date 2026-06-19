@extends('layouts.main')

@section('title', $plant->name . ' - Справочник растений')

@section('content')
<div class="fade-in-up">
    <!-- Хлебные крошки -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{ route('plants.index') }}">Каталог</a></li>
            <li class="breadcrumb-item active">{{ $plant->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Изображение -->
        <div class="col-md-6">
            @if($plant->image)
                <img src="{{ asset('storage/' . $plant->image) }}" class="img-fluid rounded-3 shadow" alt="{{ $plant->name }}">
            @else
                <div class="bg-light rounded-3 shadow d-flex align-items-center justify-content-center" style="height: 500px;">
                    <i class="bi bi-flower1" style="font-size: 8rem; color: var(--accent-green); opacity: 0.3;"></i>
                </div>
            @endif
        </div>

        <!-- Информация -->
        <div class="col-md-6">
            <h1 class="fw-bold mb-3" style="color: var(--primary-green);">{{ $plant->name }}</h1>
            <p class="fst-italic fs-4 text-muted mb-3">{{ $plant->latin_name }}</p>
            <span class="badge badge-category fs-6 mb-4">{{ $plant->category->name }}</span>
            
            <div class="mb-4">
                <h4 class="fw-semibold mb-3">
                    <i class="bi bi-info-circle me-2" style="color: var(--accent-green);"></i>Описание
                </h4>
                <p class="lead">{{ $plant->description }}</p>
            </div>

            @auth
                <div class="d-flex gap-2 flex-wrap">
                    <!-- Кнопка избранного -->
                    <form action="{{ route('favorites.toggle', $plant->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            @if(auth()->user()->favorites()->where('plant_id', $plant->id)->exists())
                                <i class="bi bi-heart-fill me-2"></i>В избранном
                            @else
                                <i class="bi bi-heart me-2"></i>В избранное
                            @endif
                        </button>
                    </form>

                    <!-- Кнопка добавления заметки -->
                    <a href="{{ route('notes.create', $plant->id) }}" class="btn btn-outline-success">
                        <i class="bi bi-journal-plus me-2"></i>Добавить заметку
                    </a>
                </div>
            @else
                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle me-2"></i>
                    <a href="{{ route('login') }}" class="alert-link">Войдите</a>, чтобы добавлять растения в избранное и создавать заметки.
                </div>
            @endauth
        </div>
    </div>

    <!-- Характеристики -->
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="section-title">
                <i class="bi bi-list-ul me-2"></i>Характеристики
            </h2>
            @if($plant->characteristics->count() > 0)
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <tbody>
                                    @foreach($plant->characteristics as $characteristic)
                                        <tr>
                                            <th class="ps-4 py-3" style="width: 30%; background: #f8f9fa; color: var(--primary-green);">
                                                {{ $characteristic->name }}
                                            </th>
                                            <td class="py-3">{{ $characteristic->value }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>Характеристики не указаны.
                </div>
            @endif
        </div>
    </div>

    <!-- Заметки пользователя к этому растению -->
    @auth
        @php
            $userNotes = $plant->notes()->where('user_id', auth()->id())->latest()->get();
        @endphp

        @if($userNotes->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <h2 class="section-title">
                        <i class="bi bi-journal-text me-2"></i>Мои заметки
                    </h2>
                    @foreach($userNotes as $note)
                        <div class="card border-0 shadow-sm mb-3" style="border-radius: 15px;">
                            <div class="card-body">
                                <p class="mb-2">{{ $note->content }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $note->created_at->format('d.m.Y H:i') }}
                                    </small>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить заметку?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endauth

    <div class="mt-4">
        <a href="{{ route('plants.index') }}" class="btn btn-outline-success">
            <i class="bi bi-arrow-left me-2"></i>Вернуться к каталогу
        </a>
    </div>
</div>
@endsection