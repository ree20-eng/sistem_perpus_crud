@extends('layouts.app')

@section('title', 'Edit Peminjaman')
@section('page-title', 'Edit Data Peminjaman')

@section('content')
<div class="card" style="max-width:680px">
    <div class="card-header">
        <span class="card-title">✏️ Form Edit Peminjaman</span>
    </div>
    <div style="padding:24px">
        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)<div>• {{ $error }}</div>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('peminjaman.update', $peminjaman->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Peminjam</label>
                <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam', $peminjaman->nama_peminjam) }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Identitas</label>
                <input type="text" name="identitas" value="{{ old('identitas', $peminjaman->identitas) }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Judul Buku</label>
                <select name="buku_id" class="form-control" required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach($bukus as $buku)
                        <option value="{{ $buku->id }}" {{ old('buku_id', $peminjaman->buku_id) == $buku->id ? 'selected' : '' }}>
                            {{ $buku->judul }} — {{ $buku->pengarang }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tenggat Kembali</label>
                    <input type="date" name="tenggat_kembali" value="{{ old('tenggat_kembali', $peminjaman->tenggat_kembali) }}" class="form-control" required>
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
                <label class="form-label">Foto Identitas <span style="color:#9ca3af;font-weight:400">(kosongkan jika tidak ingin mengubah)</span></label>
                @if($peminjaman->foto_identitas)
                    @php $ext = pathinfo($peminjaman->foto_identitas, PATHINFO_EXTENSION); @endphp
                    @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                        <img src="{{ Storage::url($peminjaman->foto_identitas) }}" style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid #e2e8f0;display:block;margin-bottom:8px">
                    @else
                        <a href="{{ Storage::url($peminjaman->foto_identitas) }}" target="_blank" style="color:#1565C0;font-size:13px;display:block;margin-bottom:8px">📄 Lihat Dokumen Saat Ini</a>
                    @endif
                @endif
                <input type="file" name="foto_identitas" accept=".jpg,.jpeg,.png,.pdf" class="form-control">
            </div>
            <div style="display:flex;gap:10px;margin-top:8px">
                <button type="submit" class="btn-save">💾 Perbarui</button>
                <a href="{{ route('peminjaman.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
