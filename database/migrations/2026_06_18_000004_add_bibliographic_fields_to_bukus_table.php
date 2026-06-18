<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->string('edisi')->nullable()->after('judul');
            $table->string('cetakan')->nullable()->after('edisi');
            $table->string('kota_terbit')->nullable()->after('penerbit');
            $table->integer('jumlah_halaman')->nullable()->after('tahun_terbit');
            $table->string('ukuran_tinggi')->nullable()->after('jumlah_halaman'); // contoh: "21 cm"
            $table->string('isbn')->nullable()->after('ukuran_tinggi');
        });
    }

    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->dropColumn(['edisi', 'cetakan', 'kota_terbit', 'jumlah_halaman', 'ukuran_tinggi', 'isbn']);
        });
    }
};
