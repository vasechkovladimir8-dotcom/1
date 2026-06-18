<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Связь: User принадлежит Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Связь: User -> избранное (много)
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Связь: User -> заметки (много)
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    // Проверка, является ли пользователь администратором
    public function isAdmin()
    {
        return $this->role_id === 2;
    }
}