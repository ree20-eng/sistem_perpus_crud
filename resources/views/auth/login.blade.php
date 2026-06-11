@extends('layouts.app')

@section('content')
<div class="login-page">
    <div class="login-card">
        <div class="login-brand">
            <div class="brand-icon">📚</div>
            <h1>Library App</h1>
            <p>Sistem Pencatatan Peminjaman Buku</p>
        </div>

        @if(session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="email@example.com" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="font-size:13px;color:#64748b;cursor:pointer">Ingat Saya</label>
            </div>
            <button type="submit" class="btn-save" style="width:100%">🔐 Login</button>
        </form>
        <p style="text-align:center;margin-top:20px;font-size:13px;color:#64748b">
            Belum punya akun? <a href="{{ route('register') }}" style="color:#1565C0;font-weight:600">Daftar di sini</a>
        </p>
        <div style="margin-top:16px;background:#f0f9ff;border-radius:8px;padding:12px;font-size:12px;color:#1e40af">
            <strong>Akun Demo:</strong><br>
            👑 Admin: admin@perpustakaan.test / password<br>
            👤 User: user@perpustakaan.test / password
        </div>
    </div>
</div>
@endsection
