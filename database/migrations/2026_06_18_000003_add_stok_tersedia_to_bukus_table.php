<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            // stok        = jumlah total eksemplar buku yang dimiliki perpustakaan
            // stok_tersedia = jumlah yang BELUM dipinjam saat ini (berkurang/bertambah otomatis)
            $table->integer('stok_tersedia')->default(0)->after('stok');
        });

        // Set nilai awal stok_tersedia = stok (anggap semua belum dipinjam)
        \DB::statement('UPDATE bukus SET stok_tersedia = stok');
    }

    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->dropColumn('stok_tersedia');
        });
    }
};
