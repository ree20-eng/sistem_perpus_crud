@extends('layouts.app')

@section('title','Edit Data')

@section('content')

<div class="card card-modern">

<div class="card-body p-4">

<h3 class="mb-4">
Edit Data Peminjaman
</h3>

<form
action="{{ route('peminjaman.update',$peminjaman->id) }}"
method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label>Nama Peminjam</label>

<input type="text"
name="nama_peminjam"
value="{{ $peminjaman->nama_peminjam }}"
class="form-control">

</div>

<div class="mb-3">

<label>Identitas</label>

<input type="text"
name="identitas"
value="{{ $peminjaman->identitas }}"
class="form-control">

</div>

<div class="mb-3">

<label>Judul Buku</label>

<input type="text"
name="judul_buku"
value="{{ $peminjaman->judul_buku }}"
class="form-control">

</div>

<div class="mb-3">

<label>Tanggal Pinjam</label>

<input type="date"
name="tanggal_pinjam"
value="{{ $peminjaman->tanggal_pinjam }}"
class="form-control">

</div>

<div class="mb-3">

<label>Tenggat Kembali</label>

<input type="date"
name="tenggat_kembali"
value="{{ $peminjaman->tenggat_kembali }}"
class="form-control">

</div>

<div class="mb-3">

<label>Status</label>

<select name="status"
class="form-control">

<option value="Dipinjam"
{{ $peminjaman->status=='Dipinjam' ? 'selected':'' }}>
Dipinjam
</option>

<option value="Sudah Dikembalikan"
{{ $peminjaman->status=='Sudah Dikembalikan' ? 'selected':'' }}>
Sudah Dikembalikan
</option>

</select>

</div>

<button class="btn btn-success">
Update Data
</button>

<a href="{{ route('peminjaman.index') }}"
class="btn btn-secondary">
Kembali
</a>

</form>

</div>

</div>

@endsection 