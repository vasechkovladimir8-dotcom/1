<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Список всех пользователей
     */
    public function index()
    {
        $users = User::with('role')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Просмотр конкретного пользователя
     */
    public function show($id)
    {
        $user = User::with(['role', 'favorites.plant', 'notes.plant'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Удаление пользователя
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Нельзя удалить самого себя
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Нельзя удалить самого себя');
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Пользователь удалён');
    }
}