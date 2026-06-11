@extends('layouts.app')

@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Data Buku')

@section('content')
<div class="card" style="max-width:560px">
    <div class="card-header"><span class="card-title">➕ Form Tambah Buku</span></div>
    <div style="padding:24px">
        @if($errors->any())
            <div class="alert-error">@foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach</div>
        @endif
        <form method="POST" action="{{ route('buku.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Judul Buku</label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Pengarang</label>
                <input type="text" name="pengarang" value="{{ old('pengarang') }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Penerbit</label>
                <input type="text" name="penerbit" value="{{ old('penerbit') }}" class="form-control" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="{{ date('Y') }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', 1) }}" min="1" class="form-control" required>
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:8px">
                <button type="submit" class="btn-save">💾 Simpan</button>
                <a href="{{ route('buku.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
