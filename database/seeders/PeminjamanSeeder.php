<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            [
                'nama_peminjam' => 'Reva Fitriani',
                'identitas' => '2210201001',
                'judul_buku' => 'Pemrograman Web Laravel',
                'tanggal_pinjam' => '2026-06-01',
                'tenggat_kembali' => '2026-06-08',
                'status' => 'Dipinjam'
            ],
            
            [
                'nama_peminjam' => 'Andi Saputra',
                'identitas' => '2210201002',
                'judul_buku' => 'Basis Data',
                'tanggal_pinjam' => '2026-06-02',
                'tenggat_kembali' => '2026-06-09',
                'status' => 'Sudah Dikembalikan'
            ],
            
            [
                'nama_peminjam' => 'Dina Putri',
                'identitas' => '2210201003',
                'judul_buku' => 'Jaringan Komputer',
                'tanggal_pinjam' => '2026-06-03',
                'tenggat_kembali' => '2026-06-10',
                'status' => 'Dipinjam'
            ],
            
            [
                'nama_peminjam' => 'Budi Santoso',
                'identitas' => '2210201004',
                'judul_buku' => 'Sistem Operasi',
                'tanggal_pinjam' => '2026-06-04',
                'tenggat_kembali' => '2026-06-11',
                'status' => 'Sudah Dikembalikan'
            ],
            
            [
                'nama_peminjam' => 'Siti Aminah',
                'identitas' => '2210201005',
                'judul_buku' => 'Analisis Sistem',
                'tanggal_pinjam' => '2026-06-05',
                'tenggat_kembali' => '2026-06-12',
                'status' => 'Dipinjam'
            ],
            
            [
                'nama_peminjam' => 'Fajar Nugroho',
                'identitas' => '2210201006',
                'judul_buku' => 'Algoritma dan Pemrograman',
                'tanggal_pinjam' => '2026-06-06',
                'tenggat_kembali' => '2026-06-13',
                'status' => 'Dipinjam'
            ],
            
            [
                'nama_peminjam' => 'Rina Kartika',
                'identitas' => '2210201007',
                'judul_buku' => 'Keamanan Jaringan',
                'tanggal_pinjam' => '2026-06-07',
                'tenggat_kembali' => '2026-06-14',
                'status' => 'Sudah Dikembalikan'
            ],
            
            [
                'nama_peminjam' => 'Agus Prasetyo',
                'identitas' => '2210201008',
                'judul_buku' => 'Data Mining',
                'tanggal_pinjam' => '2026-06-08',
                'tenggat_kembali' => '2026-06-15',
                'status' => 'Dipinjam'
            ],
            
            [
                'nama_peminjam' => 'Lina Marlina',
                'identitas' => '2210201009',
                'judul_buku' => 'Artificial Intelligence',
                'tanggal_pinjam' => '2026-06-09',
                'tenggat_kembali' => '2026-06-16',
                'status' => 'Dipinjam'
            ],
            
            [
                'nama_peminjam' => 'Dewi Anggraini',
                'identitas' => '2210201010',
                'judul_buku' => 'Cloud Computing',
                'tanggal_pinjam' => '2026-06-10',
                'tenggat_kembali' => '2026-06-17',
                'status' => 'Sudah Dikembalikan'
            ],
            
            [
                'nama_peminjam' => 'Rudi Hartono',
                'identitas' => '2210201011',
                'judul_buku' => 'Pemrograman Python',
                'tanggal_pinjam' => '2026-06-11',
                'tenggat_kembali' => '2026-06-18',
                'status' => 'Dipinjam'
            ],
            
            [
                'nama_peminjam' => 'Nabila Putri',
                'identitas' => '2210201012',
                'judul_buku' => 'Mobile Programming',
                'tanggal_pinjam' => '2026-06-12',
                'tenggat_kembali' => '2026-06-19',
                'status' => 'Sudah Dikembalikan'
            ],
            
            [
                'nama_peminjam' => 'Yoga Pratama',
                'identitas' => '2210201013',
                'judul_buku' => 'Laravel Framework',
                'tanggal_pinjam' => '2026-06-13',
                'tenggat_kembali' => '2026-06-20',
                'status' => 'Dipinjam'
            ],
            
            [
                'nama_peminjam' => 'Putri Lestari',
                'identitas' => '2210201014',
                'judul_buku' => 'UI UX Design',
                'tanggal_pinjam' => '2026-06-14',
                'tenggat_kembali' => '2026-06-21',
                'status' => 'Sudah Dikembalikan'
            ],
            
            [
                'nama_peminjam' => 'Arif Setiawan',
                'identitas' => '2210201015',
                'judul_buku' => 'Machine Learning',
                'tanggal_pinjam' => '2026-06-15',
                'tenggat_kembali' => '2026-06-22',
                'status' => 'Dipinjam'
            ]
        ];

        foreach ($data as $item) {
            Peminjaman::create($item);
        }
    }
}