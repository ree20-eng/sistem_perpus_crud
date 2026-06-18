<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanBukuController;
use App\Http\Controllers\PeminjamanMandiriController;
use App\Http\Controllers\ProfileIdentitasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK — bisa diakses siapa saja, login atau tidak
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('buku.index');
});

// Daftar buku publik dengan filter ready/habis — INI HALAMAN UTAMA
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');

/*
|--------------------------------------------------------------------------
| HALAMAN UNTUK SEMUA YANG SUDAH LOGIN (Admin & User)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Pinjam & kembalikan buku secara mandiri (Admin & User boleh pinjam juga)
    Route::post('/buku/{buku}/pinjam', [PeminjamanMandiriController::class, 'pinjam'])->name('buku.pinjam');
    Route::post('/riwayat/{peminjaman}/kembalikan', [PeminjamanMandiriController::class, 'kembalikan'])->name('riwayat.kembalikan');

    // Riwayat peminjaman milik sendiri
    Route::get('/riwayat', [PeminjamanMandiriController::class, 'riwayat'])->name('riwayat.index');

    // Lengkapi nomor identitas sebelum bisa pinjam
    Route::get('/profile/identitas', [ProfileIdentitasController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/identitas', [ProfileIdentitasController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| HALAMAN KHUSUS ADMIN — kelola data peminjaman & master buku
|--------------------------------------------------------------------------
| PENTING: route /buku/create, /buku/{buku}/edit dst HARUS didefinisikan
| SETELAH /buku (index) dan TIDAK boleh dobel dengan Route::resource,
| supaya tidak terjadi konflik middleware yang menyebabkan 403.
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {

    // CRUD Peminjaman (dikelola manual oleh Admin)
    Route::get('/peminjaman', [PeminjamanBukuController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanBukuController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanBukuController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{peminjaman}/edit', [PeminjamanBukuController::class, 'edit'])->name('peminjaman.edit');
    Route::put('/peminjaman/{peminjaman}', [PeminjamanBukuController::class, 'update'])->name('peminjaman.update');
    Route::delete('/peminjaman/{peminjaman}', [PeminjamanBukuController::class, 'destroy'])->name('peminjaman.destroy');

    // CRUD Master Buku (tambah/edit/hapus) — TANPA Route::resource, manual saja
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
});

require __DIR__.'/auth.php';