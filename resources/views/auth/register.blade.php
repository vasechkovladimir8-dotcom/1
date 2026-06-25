<x-guest-layout>
    <h3 class="text-center mb-4">Регистрация</h3>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                   value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
        
        <div class="d-grid">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-person-plus me-2"></i>Зарегистрироваться
            </button>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-decoration-none" style="color: var(--light-green);">
                Уже есть аккаунт? Войти
            </a>
        </div>
    </form>
</x-guest-layout>