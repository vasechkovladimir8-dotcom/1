<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Авторизация') - Справочник растений</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #2d5016;
            --light-green: #4a7c2c;
            --accent-green: #6ba83a;
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7f0 0%, #e8f5e9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .auth-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(45, 80, 22, 0.15);
            max-width: 450px;
            width: 100%;
            margin: auto;
        }
        
        .auth-header {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%);
            color: white;
            padding: 2rem;
            border-radius: 20px 20px 0 0;
            text-align: center;
        }
        
        .auth-header i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .auth-body {
            padding: 2.5rem;
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--light-green) 0%, var(--accent-green) 100%);
            border: none;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 10px;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(74, 124, 44, 0.3);
        }
        
        .form-control:focus {
            border-color: var(--accent-green);
            box-shadow: 0 0 0 0.2rem rgba(107, 168, 58, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-card">
            <div class="auth-header">
                <i class="bi bi-flower1"></i>
                <h2 class="mb-0">Справочник растений</h2>
            </div>
            <div class="auth-body">
                {{ $slot }}
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>