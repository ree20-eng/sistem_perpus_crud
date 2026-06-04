@extends('layouts.app')

@section('title','Tambah Data')

@section('content')

<div class="card card-modern">

<div class="card-body p-4">

<h3 class="mb-4">
Tambah Data Peminjaman
</h3>

<form action="{{ route('peminjaman.store') }}" method="POST">

@csrf

<div class="mb-3">

<label>Nama Peminjam</label>

<input type="text"
name="nama_peminjam"
value="{{ old('nama_peminjam') }}"
class="form-control">

@error('nama_peminjam')
<small class="text-danger">{{ $message }}</small>
@enderror

</div>

<div class="mb-3">

<label>Identitas</label>

<input type="text"
name="identitas"
value="{{ old('identitas') }}"
class="form-control">

@error('identitas')
<small class="text-danger">{{ $message }}</small>
@enderror

</div>

<div class="mb-3">

<label>Judul Buku</label>

<input type="text"
name="judul_buku"
value="{{ old('judul_buku') }}"
class="form-control">

</div>

<div class="mb-3">

<label>Tanggal Pinjam</label>

<input type="date"
name="tanggal_pinjam"
class="form-control">

</div>

<div class="mb-3">

<label>Tenggat Kembali</label>

<input type="date"
name="tenggat_kembali"
class="form-control">

</div>

<div class="mb-3">

<label>Status</label>

<select name="status"
class="form-control">

<option value="">Pilih</option>

<option value="Dipinjam">
Dipinjam
</option>

<option value="Sudah Dikembalikan">
Sudah Dikembalikan
</option>

</select>

</div>

<button class="btn btn-primary">
Simpan Data
</button>

<a href="{{ route('peminjaman.index') }}"
class="btn btn-secondary">
Kembali
</a>

</form>

</div>

</div>

@endsection