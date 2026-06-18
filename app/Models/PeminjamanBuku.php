<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanBuku extends Model
{
    protected $table = 'peminjaman_buku';

    protected $fillable = [
        'user_id',
        'nama_peminjam',
        'identitas',
        'buku_id',
        'tanggal_pinjam',
        'tenggat_kembali',
        'status',
        'foto_identitas',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isDipinjam(): bool
    {
        return $this->status === 'Dipinjam';
    }
}