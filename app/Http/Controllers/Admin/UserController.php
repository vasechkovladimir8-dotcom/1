<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
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
     * Показать форму изменения роли
     */
    public function editRole($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit-role', compact('user', 'roles'));
    }

    /**
     * Обновить роль пользователя
     */
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        
        // Нельзя изменить роль самого себя
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Нельзя изменить свою собственную роль');
        }

        // Нельзя изменить роль главного администратора
        if ($user->email === 'admin@admin.ru') {
            return redirect()->back()->with('error', 'Нельзя изменить роль главного администратора системы');
        }

        $oldRole = $user->role->name ?? 'неизвестно';
        
        $user->update([
            'role_id' => $request->role_id,
        ]);

        $newRole = Role::find($request->role_id)->name;

        return redirect()->route('admin.users.index')
            ->with('success', "Роль пользователя '{$user->name}' изменена с '{$oldRole}' на '{$newRole}'");
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
        
        // Нельзя удалить главного администратора
        if ($user->email === 'admin@admin.ru') {
            return redirect()->back()->with('error', 'Нельзя удалить главного администратора системы');
        }
        
        // Нельзя удалить других администраторов
        if ($user->role_id === 2) {
            return redirect()->back()->with('error', 'Нельзя удалить аккаунт администратора');
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Пользователь удалён');
    }
}