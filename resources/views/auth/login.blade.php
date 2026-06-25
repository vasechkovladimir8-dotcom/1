<x-guest-layout>
    <h3 class="text-center mb-4">Вход в систему</h3>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                   value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="d-grid">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-box-arrow-in-right me-2"></i>Войти
            </button>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('register') }}" class="text-decoration-none" style="color: var(--light-green);">
                Ещё нет аккаунта? Зарегистрироваться
            </a>
        </div>
    </form>
</x-guest-layout>