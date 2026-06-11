<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman_buku', function (Blueprint $table) {
            // Tambah kolom buku_id sebagai foreign key
            $table->foreignId('buku_id')->nullable()->constrained('bukus')->nullOnDelete()->after('identitas');
            // Tambah kolom foto identitas
            $table->string('foto_identitas')->nullable()->after('status');
        });

        // Hapus kolom judul_buku yang lama (sudah digantikan relasi)
        Schema::table('peminjaman_buku', function (Blueprint $table) {
            $table->dropColumn('judul_buku');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman_buku', function (Blueprint $table) {
            $table->dropForeign(['buku_id']);
            $table->dropColumn(['buku_id', 'foto_identitas']);
            $table->string('judul_buku')->nullable()->after('identitas');
        });
    }
};
