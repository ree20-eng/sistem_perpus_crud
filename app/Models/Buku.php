<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = [
        'judul', 'edisi', 'cetakan', 'pengarang',
        'kota_terbit', 'penerbit', 'tahun_terbit',
        'jumlah_halaman', 'ukuran_tinggi', 'isbn',
        'stok', 'stok_tersedia',
    ];

    public function peminjaman()
    {
        return $this->hasMany(PeminjamanBuku::class, 'buku_id');
    }

    public function isReady(): bool
    {
        return $this->stok_tersedia > 0;
    }

    public function kurangiStok(): void
    {
        if ($this->stok_tersedia > 0) {
            $this->decrement('stok_tersedia');
        }
    }

    public function tambahStok(): void
    {
        if ($this->stok_tersedia < $this->stok) {
            $this->increment('stok_tersedia');
        }
    }
}