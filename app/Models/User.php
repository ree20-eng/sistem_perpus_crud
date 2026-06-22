<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'identitas',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    public function peminjaman()
    {
        return $this->hasMany(PeminjamanBuku::class, 'user_id');
    }

    public function sedangMeminjam(int $bukuId): bool
    {
        return $this->peminjaman()
            ->where('buku_id', $bukuId)
            ->where('status', 'Dipinjam')
            ->exists();
    }
}