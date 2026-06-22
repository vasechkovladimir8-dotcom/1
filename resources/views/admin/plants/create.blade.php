@extends('admin.layouts.app')

@section('title', 'Добавить растение')

@section('content')
<div class="mb-4">
    <h1 class="h3 mb-1">Добавить растение</h1>
    <p class="text-muted mb-0">Заполните информацию о новом растении</p>
</div>

<div class="card table-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.plants.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Название <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Латинское название</label>
                    <input type="text" name="latin_name" class="form-control @error('latin_name') is-invalid @enderror" 
                           value="{{ old('latin_name') }}">
                    @error('latin_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Категория <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">— Выберите категорию —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Изображение</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">JPG, PNG, GIF. Макс. 2 МБ</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Описание</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Сохранить
                </button>
                <a href="{{ route('admin.plants.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>Отмена
                </a>
            </div>
        </form>
    </div>
</div>
@endsection