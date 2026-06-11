<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanBuku extends Model
{
    protected $table = 'peminjaman_buku';

    protected $fillable = [
        'nama_peminjam',
        'identitas',
        'buku_id',
        'tanggal_pinjam',
        'tenggat_kembali',
        'status',
        'foto_identitas',
    ];

    /**
     * Relasi Many-to-One: setiap peminjaman merujuk ke satu buku
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
