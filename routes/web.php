<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanBukuController;
use App\Http\Controllers\PeminjamanMandiriController;
use App\Http\Controllers\ProfileIdentitasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('buku.index');
});

Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/buku/{buku}/pinjam', [PeminjamanMandiriController::class, 'pinjam'])->name('buku.pinjam');
    Route::post('/riwayat/{peminjaman}/kembalikan', [PeminjamanMandiriController::class, 'kembalikan'])->name('riwayat.kembalikan');
});

Route::middleware(['auth', 'user_only'])->group(function () {
    Route::get('/riwayat', [PeminjamanMandiriController::class, 'riwayat'])->name('riwayat.index');
    Route::get('/profile/identitas', [ProfileIdentitasController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/identitas', [ProfileIdentitasController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/peminjaman', [PeminjamanBukuController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanBukuController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanBukuController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{peminjaman}/edit', [PeminjamanBukuController::class, 'edit'])->name('peminjaman.edit');
    Route::put('/peminjaman/{peminjaman}', [PeminjamanBukuController::class, 'update'])->name('peminjaman.update');
    Route::delete('/peminjaman/{peminjaman}', [PeminjamanBukuController::class, 'destroy'])->name('peminjaman.destroy');

    Route::get('/buku-baru', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

    // Kelola Akun Pengguna — termasuk halaman detail riwayat per akun
    Route::get('/admin/akun', [AkunController::class, 'index'])->name('admin.akun.index');
    Route::get('/admin/akun/{akun}', [AkunController::class, 'show'])->name('admin.akun.show');
    Route::get('/admin/akun/{akun}/edit', [AkunController::class, 'edit'])->name('admin.akun.edit');
    Route::put('/admin/akun/{akun}', [AkunController::class, 'update'])->name('admin.akun.update');
    Route::delete('/admin/akun/{akun}', [AkunController::class, 'destroy'])->name('admin.akun.destroy');
});

require __DIR__.'/auth.php';