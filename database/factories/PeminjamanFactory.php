<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\PeminjamanBuku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PeminjamanBuku>
 */
class PeminjamanFactory extends Factory
{
    // Arahkan ke model yang benar
    protected $model = PeminjamanBuku::class;

    public function definition(): array
    {
        // Ambil buku_id secara acak dari tabel bukus
        $bukuId = Buku::inRandomOrder()->value('id');

        return [
            'nama_peminjam'   => fake()->name(),
            'identitas'       => fake()->numerify('22102010##'),
            'buku_id'         => $bukuId, // ← pakai buku_id, bukan judul_buku
            'tanggal_pinjam'  => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'tenggat_kembali' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'status'          => fake()->randomElement([
                'Dipinjam',
                'Sudah Dikembalikan',
            ]),
            'foto_identitas'  => null,
        ];
    }
}