<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. AKUN USER ──────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@perpustakaan.test'],
            [
                'name'      => 'Administrator',
                'password'  => Hash::make('password'),
                'role'      => 'Admin',
                'identitas' => 'ADM-001',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@perpustakaan.test'],
            [
                'name'      => 'User Biasa',
                'password'  => Hash::make('password'),
                'role'      => 'User',
                'identitas' => '2210201099',
            ]
        );

        // ── 2. MASTER BUKU dengan data bibliographic lengkap ───
        $bukuList = [
            ['judul' => 'Pemrograman Web Laravel',   'edisi' => 'Edisi 2',  'cetakan' => 'Cetakan 1', 'pengarang' => 'Ridwan Kamil',       'kota_terbit' => 'Bandung',   'penerbit' => 'Informatika',     'tahun_terbit' => '2023', 'jumlah_halaman' => 320, 'ukuran_tinggi' => '23 cm', 'isbn' => '978-602-04-1001-1', 'stok' => 5],
            ['judul' => 'Basis Data',                'edisi' => 'Edisi 3',  'cetakan' => 'Cetakan 2', 'pengarang' => 'Harianto Kristanto', 'kota_terbit' => 'Yogyakarta','penerbit' => 'Andi Offset',     'tahun_terbit' => '2022', 'jumlah_halaman' => 280, 'ukuran_tinggi' => '21 cm', 'isbn' => '978-602-04-1002-8', 'stok' => 3],
            ['judul' => 'Jaringan Komputer',         'edisi' => 'Edisi 5',  'cetakan' => 'Cetakan 1', 'pengarang' => 'Andrew Tanenbaum',   'kota_terbit' => 'Jakarta',   'penerbit' => 'Pearson',         'tahun_terbit' => '2021', 'jumlah_halaman' => 960, 'ukuran_tinggi' => '24 cm', 'isbn' => '978-602-04-1003-5', 'stok' => 4],
            ['judul' => 'Sistem Operasi',            'edisi' => 'Edisi 9',  'cetakan' => 'Cetakan 1', 'pengarang' => 'William Stallings',  'kota_terbit' => 'Jakarta',   'penerbit' => 'Pearson',         'tahun_terbit' => '2022', 'jumlah_halaman' => 808, 'ukuran_tinggi' => '24 cm', 'isbn' => '978-602-04-1004-2', 'stok' => 3],
            ['judul' => 'Analisis Sistem',           'edisi' => 'Edisi 1',  'cetakan' => 'Cetakan 3', 'pengarang' => 'Al-Bahra',           'kota_terbit' => 'Yogyakarta','penerbit' => 'Graha Ilmu',      'tahun_terbit' => '2020', 'jumlah_halaman' => 196, 'ukuran_tinggi' => '21 cm', 'isbn' => '978-602-04-1005-9', 'stok' => 2],
            ['judul' => 'Algoritma dan Pemrograman', 'edisi' => 'Edisi 3',  'cetakan' => 'Cetakan 4', 'pengarang' => 'Rinaldi Munir',      'kota_terbit' => 'Bandung',   'penerbit' => 'Informatika',     'tahun_terbit' => '2021', 'jumlah_halaman' => 412, 'ukuran_tinggi' => '23 cm', 'isbn' => '978-602-04-1006-6', 'stok' => 6],
            ['judul' => 'Keamanan Jaringan',         'edisi' => 'Edisi 2',  'cetakan' => 'Cetakan 1', 'pengarang' => 'William Stallings',  'kota_terbit' => 'Jakarta',   'penerbit' => 'Pearson',         'tahun_terbit' => '2023', 'jumlah_halaman' => 752, 'ukuran_tinggi' => '24 cm', 'isbn' => '978-602-04-1007-3', 'stok' => 2],
            ['judul' => 'Data Mining',               'edisi' => 'Edisi 3',  'cetakan' => 'Cetakan 1', 'pengarang' => 'Jiawei Han',         'kota_terbit' => 'Singapura', 'penerbit' => 'Elsevier',        'tahun_terbit' => '2022', 'jumlah_halaman' => 745, 'ukuran_tinggi' => '24 cm', 'isbn' => '978-602-04-1008-0', 'stok' => 3],
            ['judul' => 'Artificial Intelligence',   'edisi' => 'Edisi 4',  'cetakan' => 'Cetakan 1', 'pengarang' => 'Stuart Russell',     'kota_terbit' => 'Jakarta',   'penerbit' => 'Pearson',         'tahun_terbit' => '2021', 'jumlah_halaman' => 1136,'ukuran_tinggi' => '25 cm', 'isbn' => '978-602-04-1009-7', 'stok' => 4],
            ['judul' => 'Cloud Computing',           'edisi' => 'Edisi 1',  'cetakan' => 'Cetakan 2', 'pengarang' => 'Thomas Erl',         'kota_terbit' => 'Jakarta',   'penerbit' => 'Prentice Hall',   'tahun_terbit' => '2020', 'jumlah_halaman' => 528, 'ukuran_tinggi' => '23 cm', 'isbn' => '978-602-04-1010-3', 'stok' => 3],
            ['judul' => 'Mobile Programming',        'edisi' => 'Edisi 2',  'cetakan' => 'Cetakan 3', 'pengarang' => 'Nazruddin Safaat',   'kota_terbit' => 'Bandung',   'penerbit' => 'Informatika',     'tahun_terbit' => '2023', 'jumlah_halaman' => 364, 'ukuran_tinggi' => '23 cm', 'isbn' => '978-602-04-1011-0', 'stok' => 5],
            ['judul' => 'UI UX Design',              'edisi' => 'Edisi 2',  'cetakan' => 'Cetakan 1', 'pengarang' => 'Don Norman',         'kota_terbit' => 'New York',  'penerbit' => 'MIT Press',       'tahun_terbit' => '2022', 'jumlah_halaman' => 368, 'ukuran_tinggi' => '22 cm', 'isbn' => '978-602-04-1012-7', 'stok' => 4],
            ['judul' => 'Machine Learning',          'edisi' => 'Edisi 1',  'cetakan' => 'Cetakan 2', 'pengarang' => 'Sebastian Raschka',  'kota_terbit' => 'Birmingham','penerbit' => 'Packt',           'tahun_terbit' => '2023', 'jumlah_halaman' => 770, 'ukuran_tinggi' => '23 cm', 'isbn' => '978-602-04-1013-4', 'stok' => 3],
            ['judul' => 'Pemrograman Python',        'edisi' => 'Edisi 3',  'cetakan' => 'Cetakan 1', 'pengarang' => 'Eric Matthes',       'kota_terbit' => 'San Francisco', 'penerbit' => 'No Starch Press', 'tahun_terbit' => '2023', 'jumlah_halaman' => 544, 'ukuran_tinggi' => '23 cm', 'isbn' => '978-602-04-1014-1', 'stok' => 5],
        ];

        foreach ($bukuList as $b) {
            $b['stok_tersedia'] = $b['stok'];
            Buku::updateOrCreate(['judul' => $b['judul']], $b);
        }

        // ── 3. DATA PEMINJAMAN DUMMY (opsional, Admin only) ────
        $this->call(PeminjamanSeeder::class);
    }
}