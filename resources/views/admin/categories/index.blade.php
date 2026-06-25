@extends('admin.layouts.app')

@section('title', 'Категории')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Категории</h1>
        <p class="text-muted mb-0">Управление категориями растений</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Добавить категорию
    </a>
</div>

<div class="card table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 100px;">Фото</th>
                        <th style="width: 60px;">#</th>
                        <th>Название</th>
                        <th style="width: 150px;">Кол-во растений</th>
                        <th style="width: 180px;">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                @if($category->image)
                                    <div style="width: 80px; height: 80px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                        <img src="{{ asset('storage/' . $category->image) }}" 
                                             alt="{{ $category->name }}"
                                             style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                    </div>
                                @else
                                    <div style="width: 80px; height: 80px; background: #e9ecef; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $category->id }}</td>
                            <td><strong>{{ $category->name }}</strong></td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $category->plants_count }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary" title="Редактировать">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить категорию «{{ $category->name }}»?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Удалить">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Категории ещё не добавлены
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($categories->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $categories->links() }}
    </div>
@endif
@endsection