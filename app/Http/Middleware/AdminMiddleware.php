<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    //Проверка является ли пользователь администратором
    public function handle(Request $request, Closure $next): Response
    {
        // Проверяем, авторизован ли пользователь
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Необходима авторизация');
        }

        // Проверяем, является ли пользователь администратором (через RoleSeeder)
        if (Auth::user()->role_id !== 2) {
            abort(403, 'Доступ запрещён. У вас нет прав администратора.');
        }

        return $next($request);
    }
}