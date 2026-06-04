@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold">Data Peminjaman Buku</h2>
        <p class="text-muted">Kelola data peminjaman perpustakaan</p>
    </div>

    <a href="{{ route('peminjaman.create') }}"
       class="btn btn-primary">
        + Tambah Data
    </a>

</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card card-modern">

<div class="card-body">

<table class="table table-hover">

<thead>
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Identitas</th>
    <th>Judul Buku</th>
    <th>Tgl Pinjam</th>
    <th>Tenggat</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse($data as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item->nama_peminjam }}</td>

<td>{{ $item->identitas }}</td>

<td>{{ $item->judul_buku }}</td>

<td>{{ $item->tanggal_pinjam }}</td>

<td>{{ $item->tenggat_kembali }}</td>

<td>

@if($item->status=='Dipinjam')

<span class="badge bg-warning text-dark">
Dipinjam
</span>

@else

<span class="badge bg-success">
Dikembalikan
</span>

@endif

</td>

<td>

<a href="{{ route('peminjaman.edit',$item->id) }}"
class="btn btn-warning btn-sm">
Edit
</a>

<form
action="{{ route('peminjaman.destroy',$item->id) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button
onclick="return confirm('Yakin hapus data?')"
class="btn btn-danger btn-sm">

Hapus

</button>

</form>

</td>

</tr>

@empty

<tr>

<td colspan="8" class="text-center">
Belum ada data
</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

@endsection