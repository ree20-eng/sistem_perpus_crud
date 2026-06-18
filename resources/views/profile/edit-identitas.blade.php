@extends('layouts.app')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil Saya')

@section('content')
<div class="card" style="max-width:520px">
    <div class="card-header"><span class="card-title">👤 Edit Profil</span></div>
    <div style="padding:24px">
        <p style="font-size:13px;color:#64748b;margin-bottom:16px">
            Nomor identitas (NIM/NIP/KTP) akan otomatis dipakai setiap kali Anda meminjam buku, sehingga tidak perlu mengisi ulang.
        </p>

        @if($errors->any())
            <div class="alert-error">@foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Nomor Identitas (NIM/NIP/KTP)</label>
                <input type="text" name="identitas" value="{{ old('identitas', auth()->user()->identitas) }}"
                       class="form-control" placeholder="Contoh: 2210201099" required>
            </div>

            <hr style="border:none;border-top:1px solid #f1f5f9;margin:20px 0">

            <div class="form-group">
                <label class="form-label">Password Baru <span style="color:#9ca3af;font-weight:400">(kosongkan jika tidak ingin mengubah)</span></label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div style="display:flex;align-items:center;gap:10px;margin-top:8px">
                <span style="font-size:13px;color:#64748b">Role saat ini:</span>
                <span class="badge" style="background:#dbeafe;color:#1e40af">{{ auth()->user()->role }}</span>
            </div>

            <button type="submit" class="btn-save" style="width:100%;margin-top:16px">💾 Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection