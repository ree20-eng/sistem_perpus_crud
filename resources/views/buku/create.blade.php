@extends('layouts.app')

@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Data Buku')

@section('content')
<div class="card" style="max-width:680px">
    <div class="card-header"><span class="card-title">📖 Form Tambah Data Bibliografi Buku</span></div>
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

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Edisi <span style="color:#9ca3af;font-weight:400">(opsional)</span></label>
                    <input type="text" name="edisi" value="{{ old('edisi') }}" class="form-control" placeholder="Contoh: Edisi 2">
                </div>
                <div class="form-group">
                    <label class="form-label">Cetakan <span style="color:#9ca3af;font-weight:400">(opsional)</span></label>
                    <input type="text" name="cetakan" value="{{ old('cetakan') }}" class="form-control" placeholder="Contoh: Cetakan 1">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Pengarang</label>
                <input type="text" name="pengarang" value="{{ old('pengarang') }}" class="form-control" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kota Terbit <span style="color:#9ca3af;font-weight:400">(opsional)</span></label>
                    <input type="text" name="kota_terbit" value="{{ old('kota_terbit') }}" class="form-control" placeholder="Contoh: Jakarta">
                </div>
                <div class="form-group">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="penerbit" value="{{ old('penerbit') }}" class="form-control" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="{{ date('Y') }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jumlah Halaman <span style="color:#9ca3af;font-weight:400">(opsional)</span></label>
                    <input type="number" name="jumlah_halaman" value="{{ old('jumlah_halaman') }}" min="1" class="form-control" placeholder="Contoh: 240">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Ukuran Tinggi Buku <span style="color:#9ca3af;font-weight:400">(opsional)</span></label>
                    <input type="text" name="ukuran_tinggi" value="{{ old('ukuran_tinggi') }}" class="form-control" placeholder="Contoh: 21 cm">
                </div>
                <div class="form-group">
                    <label class="form-label">ISBN <span style="color:#9ca3af;font-weight:400">(opsional)</span></label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}" class="form-control" placeholder="Contoh: 978-602-04-1234-5">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Jumlah Stok / Eksemplar</label>
                <input type="number" name="stok" value="{{ old('stok', 1) }}" min="1" class="form-control" required>
            </div>

            <div style="display:flex;gap:10px;margin-top:8px">
                <button type="submit" class="btn-save">💾 Simpan</button>
                <a href="{{ route('buku.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection