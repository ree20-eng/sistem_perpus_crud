@extends('layouts.app')

@section('title', 'Tambah Peminjaman')
@section('page-title', 'Tambah Data Peminjaman')

@section('content')
<div class="card" style="max-width:680px">
    <div class="card-header">
        <span class="card-title">➕ Form Tambah Peminjaman</span>
    </div>
    <div style="padding:24px">
        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)<div>• {{ $error }}</div>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('peminjaman.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Peminjam</label>
                <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam') }}" class="form-control" placeholder="Masukkan nama peminjam" required>
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Identitas (NIM/NIP/KTP)</label>
                <input type="text" name="identitas" value="{{ old('identitas') }}" class="form-control" placeholder="Masukkan nomor identitas" required>
            </div>
            <div class="form-group">
                <label class="form-label">Judul Buku</label>
                <select name="buku_id" class="form-control" required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach($bukus as $buku)
                        <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                            {{ $buku->judul }} — {{ $buku->pengarang }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tenggat Kembali</label>
                    <input type="date" name="tenggat_kembali" value="{{ old('tenggat_kembali') }}" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="Dipinjam" 
                        {{ old('status', $peminjaman->status) == 'Dipinjam' ? 'selected' : '' }}> Dipinjam</option>
                                <option value="Sudah Dikembalikan" 
                        {{ old('status', $peminjaman->status) == 'Sudah Dikembalikan' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Foto Identitas <span style="color:#9ca3af;font-weight:400">(JPG/PNG/PDF, maks 2MB)</span></label>
                <input type="file" name="foto_identitas" accept=".jpg,.jpeg,.png,.pdf" class="form-control">
            </div>
            <div style="display:flex;gap:10px;margin-top:8px">
                <button type="submit" class="btn-save">💾 Simpan</button>
                <a href="{{ route('peminjaman.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
