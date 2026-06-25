@extends('layouts.main')

@section('title', 'Редактирование профиля')

@section('content')
<div class="fade-in-up">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h3 class="mb-4">
                        <i class="bi bi-person-circle me-2" style="color: var(--accent-green);"></i>
                        Редактирование профиля
                    </h3>
                    
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Имя</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle me-2"></i>Сохранить
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Отмена
                            </a>
                        </div>
                    </form>
                    
                    <hr class="my-4">

                    <h5 class="mb-3">Удаление аккаунта</h5>

                    @php
                        // Проверяем, является ли пользователь администратором
                        $isAdmin = auth()->user()->role && auth()->user()->role->name === 'admin';
                    @endphp

                    @if(!$isAdmin)
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Внимание!</strong> Это действие нельзя отменить.
                        </div>
                        
                        <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Вы уверены? Все ваши данные будут удалены.')">
                            @csrf
                            @method('DELETE')
                            
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-2"></i>Удалить аккаунт
                            </button>
                        </form>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-shield-lock me-2"></i>
                            <strong>Аккаунт администратора не может быть удалён</strong><br>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection