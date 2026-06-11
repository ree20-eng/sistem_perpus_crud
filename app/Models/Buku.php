<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = ['judul', 'pengarang', 'penerbit', 'tahun_terbit', 'stok'];

    /**
     * Relasi One-to-Many: satu buku bisa dipinjam berkali-kali
     */
    public function peminjaman()
    {
        return $this->hasMany(PeminjamanBuku::class, 'buku_id');
    }
}
