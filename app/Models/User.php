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

    /**
     * Semua riwayat peminjaman milik user ini
     */
    public function peminjaman()
    {
        return $this->hasMany(PeminjamanBuku::class, 'user_id');
    }

    /**
     * Cek apakah user masih punya peminjaman aktif untuk buku tertentu
     */
    public function sedangMeminjam(int $bukuId): bool
    {
        return $this->peminjaman()
            ->where('buku_id', $bukuId)
            ->where('status', 'Dipinjam')
            ->exists();
    }
}