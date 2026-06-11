@extends('layouts.app')

@section('title', 'Akses Ditolak')

@section('content')
<div class="max-w-lg mx-auto text-center py-20">
    <div class="text-8xl mb-6">🚫</div>
    <h1 class="text-4xl font-bold text-gray-800 mb-3">403</h1>
    <p class="text-xl text-gray-600 mb-2">Akses Ditolak</p>
    <p class="text-gray-500 mb-8">
        Anda tidak memiliki izin untuk mengakses halaman ini.<br>
        Hanya <strong>Admin</strong> yang dapat melakukan aksi ini.
    </p>
    <a href="{{ route('peminjaman.index') }}"
       class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
        ← Kembali ke Beranda
    </a>
</div>
@endsection
