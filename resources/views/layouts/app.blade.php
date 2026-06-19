<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Справочник комнатных растений')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #2d5016;
            --light-green: #4a7c2c;
            --accent-green: #6ba83a;
            --bg-light: #f5f7f0;
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7f0 0%, #e8f5e9 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1;
        }
        
        /* Навигация */
        .navbar {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .navbar-brand i {
            font-size: 1.8rem;
        }
        
        .nav-link {
            font-weight: 500;
            transition: all 0.3s;
            position: relative;
        }
        
        .nav-link:hover {
            transform: translateY(-2px);
        }
        
        /* Карточки растений */
        .plant-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.07);
            height: 100%;
        }
        
        .plant-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(45, 80, 22, 0.15);
        }
        
        .plant-image {
            height: 220px;
            object-fit: cover;
            transition: transform 0.3s;
        }
        
        .plant-card:hover .plant-image {
            transform: scale(1.05);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-title {
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 0.5rem;
        }
        
        .card-text {
            color: #666;
        }
        
        /* Кнопки */
        .btn-success {
            background: linear-gradient(135deg, var(--light-green) 0%, var(--accent-green) 100%);
            border: none;
            font-weight: 500;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(74, 124, 44, 0.3);
        }
        
        .btn-outline-success {
            border: 2px solid var(--light-green);
            color: var(--light-green);
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-outline-success:hover {
            background: var(--light-green);
            border-color: var(--light-green);
            transform: translateY(-2px);
        }
        
        /* Hero секция */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--accent-green) 100%);
            color: white;
            padding: 4rem 0;
            border-radius: 20px;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 500px;
            height: 500px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        /* Категории */
        .category-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
            border: 2px solid transparent;
            height: 100%;
        }
        
        .category-card:hover {
            border-color: var(--accent-green);
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        
        .category-icon {
            font-size: 3rem;
            color: var(--accent-green);
            margin-bottom: 1rem;
        }
        
        /* Заголовки секций */
        .section-title {
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--accent-green);
            border-radius: 2px;
        }
        
        /* Футер */
        footer {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            margin-top: auto;
        }
        
        /* Анимации */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        /* Бейджи */
        .badge-category {
            background: linear-gradient(135deg, var(--light-green) 0%, var(--accent-green) 100%);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <!-- Навигация -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-flower1"></i>
                Справочник растений
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i>Главная
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('plants.index') }}">
                            <i class="bi bi-grid me-1"></i>Каталог
                        </a>
                    </li>

                    @if(Route::has('login'))
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Войти
                                </a>
                            </li>
                            @if(Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="bi bi-person-plus me-1"></i>Регистрация
                                    </a>
                                </li>
                            @endif
                        @else
                            @if(Route::has('favorites.index'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('favorites.index') }}">
                                        <i class="bi bi-heart me-1"></i>Избранное
                                    </a>
                                </li>
                            @endif
                            @if(Route::has('notes.index'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('notes.index') }}">
                                        <i class="bi bi-journal-text me-1"></i>Заметки
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->isAdmin() && Route::has('admin.dashboard'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-1"></i>Админка
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-box-arrow-right me-1"></i>Выйти
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Основной контент -->
    <main class="container my-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show fade-in-up">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show fade-in-up">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show fade-in-up">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Футер -->
    <footer class="text-white text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-2">
                <i class="bi bi-flower1 me-2"></i>
                Справочник комнатных растений
            </p>
            <p class="mb-0 small opacity-75">© 2026 Все права защищены</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>