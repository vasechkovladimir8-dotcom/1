@extends('admin.layouts.app')

@section('title', 'Редактировать категорию')

@section('content')
<div class="mb-4">
    <h1 class="h3 mb-1">Редактировать категорию</h1>
    <p class="text-muted mb-0">Изменение категории «{{ $category->name }}»</p>
</div>

<div class="card table-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Название категории <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $category->name) }}" required maxlength="255">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Изображение категории</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                <small class="text-muted">JPG, PNG, GIF. Макс. 2 МБ. Загрузите новое, чтобы заменить текущее.</small>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                @if($category->image)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="Текущее изображение" 
                             style="max-width: 200px; max-height: 150px; border-radius: 8px;">
                    </div>
                @endif
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Сохранить изменения
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>Отмена
                </a>
            </div>
        </form>
    </div>
</div>
@endsection