<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanFactory extends Factory
{
    public function definition(): array
    {
        return [

            'nama_peminjam' => fake()->name(),

            'identitas' => fake()->numerify('TI#####'),

            'judul_buku' => fake()->sentence(3),

            'tanggal_pinjam' => fake()->date(),

            'tenggat_kembali' => fake()->date(),

            'status' => fake()->randomElement([
                'Dipinjam',
                'Sudah Dikembalikan'
            ])
        ];
    }
}