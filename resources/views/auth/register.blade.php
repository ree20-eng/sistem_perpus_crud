@extends('layouts.app')

@section('content')
<div class="login-page">
    <div class="login-card">
        <div class="login-brand">
            <div class="brand-icon">📚</div>
            <h1>Daftar Akun</h1>
            <p>Library App — Sistem Peminjaman Buku</p>
        </div>

        @if($errors->any())
            <div class="alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Identitas (NIM/NIP/KTP) <span style="color:#9ca3af;font-weight:400">opsional, bisa diisi nanti</span></label>
                <input type="text" name="identitas" value="{{ old('identitas') }}" class="form-control" placeholder="Contoh: 2210201099">
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn-save" style="width:100%">📝 Daftar</button>
        </form>
        <p style="text-align:center;margin-top:20px;font-size:13px;color:#64748b">
            Sudah punya akun? <a href="{{ route('login') }}" style="color:#1565C0;font-weight:600">Login di sini</a>
        </p>
    </div>
</div>
@endsection