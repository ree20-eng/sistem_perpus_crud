<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_buku';

    protected $fillable = [
        'nama_peminjam',
        'identitas',
        'judul_buku',
        'tanggal_pinjam',
        'tenggat_kembali',
        'status'
    ];
}