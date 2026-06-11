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
                'name'     => 'Administrator',
                'password' => Hash::make('password'),
                'role'     => 'Admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@perpustakaan.test'],
            [
                'name'     => 'User Biasa',
                'password' => Hash::make('password'),
                'role'     => 'User',
            ]
        );

        // ── 2. MASTER BUKU ─────────────────────────────────────
        $bukuList = [
            ['judul' => 'Pemrograman Web Laravel',   'pengarang' => 'Ridwan Kamil',       'penerbit' => 'Informatika',     'tahun_terbit' => '2023', 'stok' => 5],
            ['judul' => 'Basis Data',                'pengarang' => 'Harianto Kristanto', 'penerbit' => 'Andi Offset',     'tahun_terbit' => '2022', 'stok' => 3],
            ['judul' => 'Jaringan Komputer',         'pengarang' => 'Andrew Tanenbaum',   'penerbit' => 'Pearson',         'tahun_terbit' => '2021', 'stok' => 4],
            ['judul' => 'Sistem Operasi',            'pengarang' => 'William Stallings',  'penerbit' => 'Pearson',         'tahun_terbit' => '2022', 'stok' => 3],
            ['judul' => 'Analisis Sistem',           'pengarang' => 'Al-Bahra',           'penerbit' => 'Graha Ilmu',      'tahun_terbit' => '2020', 'stok' => 2],
            ['judul' => 'Algoritma dan Pemrograman', 'pengarang' => 'Rinaldi Munir',      'penerbit' => 'Informatika',     'tahun_terbit' => '2021', 'stok' => 6],
            ['judul' => 'Keamanan Jaringan',         'pengarang' => 'William Stallings',  'penerbit' => 'Pearson',         'tahun_terbit' => '2023', 'stok' => 2],
            ['judul' => 'Data Mining',               'pengarang' => 'Jiawei Han',         'penerbit' => 'Elsevier',        'tahun_terbit' => '2022', 'stok' => 3],
            ['judul' => 'Artificial Intelligence',   'pengarang' => 'Stuart Russell',     'penerbit' => 'Pearson',         'tahun_terbit' => '2021', 'stok' => 4],
            ['judul' => 'Cloud Computing',           'pengarang' => 'Thomas Erl',         'penerbit' => 'Prentice Hall',   'tahun_terbit' => '2020', 'stok' => 3],
            ['judul' => 'Mobile Programming',        'pengarang' => 'Nazruddin Safaat',   'penerbit' => 'Informatika',     'tahun_terbit' => '2023', 'stok' => 5],
            ['judul' => 'UI UX Design',              'pengarang' => 'Don Norman',         'penerbit' => 'MIT Press',       'tahun_terbit' => '2022', 'stok' => 4],
            ['judul' => 'Machine Learning',          'pengarang' => 'Sebastian Raschka',  'penerbit' => 'Packt',           'tahun_terbit' => '2023', 'stok' => 3],
            ['judul' => 'Pemrograman Python',        'pengarang' => 'Eric Matthes',       'penerbit' => 'No Starch Press', 'tahun_terbit' => '2023', 'stok' => 5],
        ];

        foreach ($bukuList as $b) {
            Buku::firstOrCreate(['judul' => $b['judul']], $b);
        }

        // ── 3. PANGGIL PeminjamanSeeder ────────────────────────
        $this->call(PeminjamanSeeder::class);
    }
}