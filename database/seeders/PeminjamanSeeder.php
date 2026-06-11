<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\PeminjamanBuku; // ← model yang benar
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Reva Fitriani',  'nim' => '2210201001', 'judul' => 'Pemrograman Web Laravel',   'pinjam' => '2026-06-01', 'kembali' => '2026-06-08', 'status' => 'Dipinjam'],
            ['nama' => 'Andi Saputra',   'nim' => '2210201002', 'judul' => 'Basis Data',                'pinjam' => '2026-06-02', 'kembali' => '2026-06-09', 'status' => 'Sudah Dikembalikan'],
            ['nama' => 'Dina Putri',     'nim' => '2210201003', 'judul' => 'Jaringan Komputer',         'pinjam' => '2026-06-03', 'kembali' => '2026-06-10', 'status' => 'Dipinjam'],
            ['nama' => 'Budi Santoso',   'nim' => '2210201004', 'judul' => 'Sistem Operasi',            'pinjam' => '2026-06-04', 'kembali' => '2026-06-11', 'status' => 'Sudah Dikembalikan'],
            ['nama' => 'Siti Aminah',    'nim' => '2210201005', 'judul' => 'Analisis Sistem',           'pinjam' => '2026-06-05', 'kembali' => '2026-06-12', 'status' => 'Dipinjam'],
            ['nama' => 'Fajar Nugroho',  'nim' => '2210201006', 'judul' => 'Algoritma dan Pemrograman', 'pinjam' => '2026-06-06', 'kembali' => '2026-06-13', 'status' => 'Dipinjam'],
            ['nama' => 'Rina Kartika',   'nim' => '2210201007', 'judul' => 'Keamanan Jaringan',         'pinjam' => '2026-06-07', 'kembali' => '2026-06-14', 'status' => 'Sudah Dikembalikan'],
            ['nama' => 'Agus Prasetyo',  'nim' => '2210201008', 'judul' => 'Data Mining',               'pinjam' => '2026-06-08', 'kembali' => '2026-06-15', 'status' => 'Dipinjam'],
            ['nama' => 'Lina Marlina',   'nim' => '2210201009', 'judul' => 'Artificial Intelligence',   'pinjam' => '2026-06-09', 'kembali' => '2026-06-16', 'status' => 'Dipinjam'],
            ['nama' => 'Dewi Anggraini', 'nim' => '2210201010', 'judul' => 'Cloud Computing',           'pinjam' => '2026-06-10', 'kembali' => '2026-06-17', 'status' => 'Sudah Dikembalikan'],
            ['nama' => 'Rudi Hartono',   'nim' => '2210201011', 'judul' => 'Pemrograman Python',        'pinjam' => '2026-06-11', 'kembali' => '2026-06-18', 'status' => 'Dipinjam'],
            ['nama' => 'Nabila Putri',   'nim' => '2210201012', 'judul' => 'Mobile Programming',        'pinjam' => '2026-06-12', 'kembali' => '2026-06-19', 'status' => 'Sudah Dikembalikan'],
            ['nama' => 'Yoga Pratama',   'nim' => '2210201013', 'judul' => 'UI UX Design',              'pinjam' => '2026-06-13', 'kembali' => '2026-06-20', 'status' => 'Dipinjam'],
            ['nama' => 'Putri Lestari',  'nim' => '2210201014', 'judul' => 'Machine Learning',          'pinjam' => '2026-06-14', 'kembali' => '2026-06-21', 'status' => 'Sudah Dikembalikan'],
            ['nama' => 'Arif Setiawan',  'nim' => '2210201015', 'judul' => 'Pemrograman Python',        'pinjam' => '2026-06-15', 'kembali' => '2026-06-22', 'status' => 'Dipinjam'],
        ];

        foreach ($data as $item) {
            // Cari buku berdasarkan judul
            $buku = Buku::where('judul', $item['judul'])->first();

            if ($buku) {
                PeminjamanBuku::firstOrCreate(
                    [
                        'nama_peminjam' => $item['nama'],
                        'identitas'     => $item['nim'],
                    ],
                    [
                        'buku_id'         => $buku->id, // ← pakai id buku
                        'tanggal_pinjam'  => $item['pinjam'],
                        'tenggat_kembali' => $item['kembali'],
                        'status'          => $item['status'],
                        'foto_identitas'  => null,
                    ]
                );
            }
        }
    }
}