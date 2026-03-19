<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Modelo que representa a un usuario del sistema
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Atributos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'security_question',
        'security_answer',
        'login_attempts',
        'is_blocked',
    ];

    // Atributos que deben ocultarse en la serialización
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Definir el tipo de datos de ciertos atributos
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_blocked' => 'boolean',
            'login_attempts' => 'integer',
        ];
    }
}
