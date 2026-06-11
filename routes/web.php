<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanBukuController;
use Illuminate\Support\Facades\Route;

// HALAMAN PUBLIK
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('login.index');
    }
    return redirect()->route('login');
});
    Route::middleware(['auth'])->group(function () {

     Route::get('/peminjaman', [PeminjamanBukuController::class, 'index'])->name('peminjaman.index');

 // Khusus Admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/peminjaman/create', [PeminjamanBukuController::class, 'create'])->name('peminjaman.create');
        Route::post('/peminjaman', [PeminjamanBukuController::class, 'store'])->name('peminjaman.store');
        Route::get('/peminjaman/{peminjaman}/edit', [PeminjamanBukuController::class, 'edit'])->name('peminjaman.edit');
        Route::put('/peminjaman/{peminjaman}', [PeminjamanBukuController::class, 'update'])->name('peminjaman.update');
        Route::delete('/peminjaman/{peminjaman}', [PeminjamanBukuController::class, 'destroy'])->name('peminjaman.destroy');

        Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
    });
});

require __DIR__.'/auth.php';