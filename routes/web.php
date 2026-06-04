<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;

Route::redirect('/', '/peminjaman');

Route::resource(
    'peminjaman',
    PeminjamanController::class
);