@extends('admin.layouts.app')

@section('title', 'Растения')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Растения</h1>
        <p class="text-muted mb-0">Управление каталогом растений</p>
    </div>
    <a href="{{ route('admin.plants.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Добавить растение
    </a>
</div>

<div class="card table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;">Фото</th>
                        <th>Название</th>
                        <th>Латинское название</th>
                        <th>Категория</th>
                        <th style="width: 180px;">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plants as $plant)
                        <tr>
                            <td>
                                @if($plant->image)
                                    <img src="{{ asset('storage/' . $plant->image) }}" 
                                         alt="{{ $plant->name }}" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <div style="width: 50px; height: 50px; background: #e9ecef; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $plant->name }}</strong></td>
                            <td class="fst-italic text-muted">{{ $plant->latin_name }}</td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $plant->category->name }}</span>
                            </td>
                            <td>
                                <a href="{{ route('plants.show', $plant->id) }}" class="btn btn-sm btn-outline-secondary" title="Просмотр">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.plants.edit', $plant->id) }}" class="btn btn-sm btn-outline-primary" title="Редактировать">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.plants.destroy', $plant->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить растение «{{ $plant->name }}»?')">
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
                                Растения ещё не добавлены
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($plants->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $plants->links() }}
    </div>
@endif
@endsection