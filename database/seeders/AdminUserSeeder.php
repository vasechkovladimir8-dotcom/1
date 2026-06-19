<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@admin.ru',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id,
        ]);
        
        $this->command->info('✅ Админ создан!');
        $this->command->info('Email: admin@admin.ru');
        $this->command->info('Пароль: admin123');
    }
}