@extends('layouts.app')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Data Buku')

@section('content')
<div class="card" style="max-width:560px">
    <div class="card-header"><span class="card-title">✏️ Form Edit Buku</span></div>
    <div style="padding:24px">
        @if($errors->any())
            <div class="alert-error">@foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach</div>
        @endif
        <form method="POST" action="{{ route('buku.update', $buku->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Judul Buku</label>
                <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Pengarang</label>
                <input type="text" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Penerbit</label>
                <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="form-control" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" min="1900" max="{{ date('Y') }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" min="1" class="form-control" required>
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:8px">
                <button type="submit" class="btn-save">💾 Perbarui</button>
                <a href="{{ route('buku.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
