@extends('admin.layouts.app')

@section('title', 'Изменить роль')

@section('content')
<div class="mb-4">
    <h1 class="h3 mb-1">Изменить роль пользователя</h1>
    <p class="text-muted mb-0">Пользователь: {{ $user->name }}</p>
</div>

<div class="card table-card">
    <div class="card-body p-4">
        @if($user->email === 'admin@admin.ru')
            <div class="alert alert-warning">
                <i class="bi bi-shield-lock me-2"></i>
                <strong>Роль главного администратора не может быть изменена</strong><br>
                <small class="text-muted">Это ограничение безопасности для защиты системы.</small>
            </div>
        @else
            <form action="{{ route('admin.users.update-role', $user->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Текущая роль</label>
                    <div class="form-control-plaintext">
                        @if($user->role)
                            <span class="badge bg-{{ $user->role->name === 'admin' ? 'danger' : 'secondary' }} fs-6">
                                {{ $user->role->name }}
                            </span>
                        @else
                            <span class="text-muted">Не назначена</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="role_id" class="form-label">Новая роль <span class="text-danger">*</span></label>
                    <select name="role_id" id="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                        <option value="">— Выберите роль —</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if($user->id === auth()->id())
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Вы не можете изменить свою собственную роль
                    </div>
                @endif

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        <i class="bi bi-check-circle me-2"></i>Сохранить
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-2"></i>Отмена
                    </a>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection