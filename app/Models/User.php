<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nama tabel (override default "users")
     */
    protected $table = 'user'; // <-- PENTING

    /**
     * Kolom yang boleh di-insert (mass assignment)
     */
    protected $fillable = [
        'user_code',
        'company_name',
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
    ];


    /**
     * Kolom yang disembunyikan
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast attribute
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
