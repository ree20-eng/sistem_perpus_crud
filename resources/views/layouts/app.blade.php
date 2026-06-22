<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library App - @yield('title', 'Sistem Peminjaman')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; display: flex; min-height: 100vh; }
        .sidebar { width: 220px; background: linear-gradient(180deg, #1a3a8f 0%, #1565C0 100%); min-height: 100vh; padding: 0; position: fixed; top: 0; left: 0; display: flex; flex-direction: column; z-index: 100; }
        .sidebar-brand { padding: 20px 20px 16px; border-bottom: 1px solid rgba(255,255,255,0.15); display: flex; align-items: center; gap: 10px; }
        .sidebar-brand .icon { width: 36px; height: 36px; background: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .sidebar-brand span { color: white; font-size: 16px; font-weight: 700; letter-spacing: 0.3px; }
        .sidebar-nav { padding: 16px 0; flex: 1; }
        .sidebar-nav a { display: flex; align-items: center; gap: 10px; padding: 11px 20px; color: rgba(255,255,255,0.8); text-decoration: none; font-size: 14px; transition: all 0.2s; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(255,255,255,0.15); color: white; border-left: 3px solid white; padding-left: 17px; }
        .sidebar-nav a .nav-icon { font-size: 16px; width: 20px; text-align: center; }
        .sidebar-divider { border: none; border-top: 1px solid rgba(255,255,255,0.1); margin: 8px 16px; }
        .sidebar-bottom { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.15); }
        .user-info { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .user-avatar { width: 34px; height: 34px; background: rgba(255,255,255,0.25); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; color: white; }
        .user-details .user-name { color: white; font-size: 13px; font-weight: 600; }
        .user-details .user-role { font-size: 11px; background: rgba(255,255,255,0.2); color: rgba(255,255,255,0.9); padding: 1px 7px; border-radius: 10px; display: inline-block; margin-top: 2px; }
        .btn-logout { width: 100%; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.8); padding: 7px; border-radius: 6px; cursor: pointer; font-size: 13px; transition: all 0.2s; }
        .btn-logout:hover { background: rgba(255,255,255,0.2); color: white; }
        .main-content { margin-left: 220px; flex: 1; display: flex; flex-direction: column; }
        .topbar { background: white; padding: 14px 28px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #e5e7eb; position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: 20px; font-weight: 700; color: #1e293b; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .btn-primary { background: #1565C0; color: white; padding: 8px 18px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: background 0.2s; }
        .btn-primary:hover { background: #1a3a8f; }
        .page-content { padding: 24px 28px; flex: 1; }
        .alert-success { background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 10px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .alert-error { background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 10px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .card { background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); overflow: hidden; }
        .card-header { padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-size: 16px; font-weight: 700; color: #1e293b; }
        .card-body { padding: 0; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead { background: #f8fafc; }
        thead th { padding: 12px 16px; text-align: left; font-weight: 600; color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0; }
        tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
        tbody tr:hover { background: #f8fafc; }
        tbody tr:last-child { border-bottom: none; }
        tbody td { padding: 12px 16px; color: #374151; vertical-align: middle; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-dipinjam { background: #fef3c7; color: #92400e; }
        .badge-kembali { background: #d1fae5; color: #065f46; }
        .btn-edit { background: #f59e0b; color: white; padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; display: inline-block; transition: background 0.2s; }
        .btn-edit:hover { background: #d97706; }
        .btn-delete { background: #ef4444; color: white; padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; transition: background 0.2s; }
        .btn-delete:hover { background: #dc2626; }
        .btn-save { background: #1565C0; color: white; padding: 9px 22px; border-radius: 8px; font-size: 14px; font-weight: 600; border: none; cursor: pointer; transition: background 0.2s; }
        .btn-save:hover { background: #1a3a8f; }
        .btn-cancel { background: #e5e7eb; color: #374151; padding: 9px 22px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-block; transition: background 0.2s; }
        .btn-cancel:hover { background: #d1d5db; }
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .form-control { width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 9px 12px; font-size: 14px; color: #374151; transition: border-color 0.2s; background: white; }
        .form-control:focus { outline: none; border-color: #1565C0; box-shadow: 0 0 0 3px rgba(21,101,192,0.1); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .empty-state { text-align: center; padding: 48px; color: #9ca3af; font-size: 14px; }
        .guest-topbar { background: white; padding: 14px 28px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #e5e7eb; }
        .guest-brand { display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 17px; color: #1e293b; text-decoration:none; }
        .guest-brand .icon { width: 32px; height: 32px; background: #1565C0; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; }
        .guest-auth-links { display: flex; gap: 10px; align-items: center; }
        .link-login { color: #1565C0; font-size: 13px; font-weight: 600; text-decoration: none; padding: 7px 14px; }
        .btn-register { background: #1565C0; color: white; padding: 7px 16px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; }
        .login-page { min-height: calc(100vh - 64px); background: linear-gradient(135deg, #1a3a8f 0%, #1565C0 100%); display: flex; align-items: center; justify-content: center; }
        .login-card { background: white; border-radius: 16px; padding: 40px; width: 100%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
        .login-brand { text-align: center; margin-bottom: 28px; }
        .login-brand .brand-icon { width: 60px; height: 60px; background: #1565C0; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 12px; }
        .login-brand h1 { font-size: 22px; font-weight: 700; color: #1e293b; }
        .login-brand p { font-size: 13px; color: #64748b; margin-top: 4px; }

        /* MODAL */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(15,23,42,0.6);
    z-index: 999;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(2px);
}
.modal-box {
    background: white;
    border-radius: 16px;
    padding: 28px;
    max-width: 380px;
    width: 90%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
}
.modal-title {
    font-size: 17px;
    font-weight: 700;
    color: #0F172A;
    margin-bottom: 4px;
}
.modal-subtitle {
    font-size: 13px;
    color: #64748B;
    margin-bottom: 20px;
}
.tenggat-preview {
    background: #EEF2FF;
    border-radius: 8px;
    padding: 12px 14px;
    margin-bottom: 18px;
    font-size: 13px;
    color: #3730A3;
}
.tenggat-date {
    font-weight: 700;
    font-size: 16px;
    margin-top: 2px;
}
.durasi-btn-active {
    background: #6366F1 !important;
    color: white !important;
    border-color: #6366F1 !important;
    box-shadow: 0 4px 10px rgba(99,102,241,0.35);
    transform: translateY(-2px);
}
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    text-decoration: none;
    transition: all 0.15s ease;
    font-family: 'Segoe UI', sans-serif;
}
.btn-primary { background: #6366F1; color: white; }
.btn-primary:hover { background: #4F46E5; }
.btn-secondary { background: #F1F5F9; color: #334155; border: 1px solid #E2E8F0; }
.btn-secondary:hover { background: #E2E8F0; }
.btn-sm { padding: 5px 12px; font-size: 12px; }
    </style>
</head>
<body>

@auth
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="icon">📚</div>
        <span>Library App</span>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.index') ? 'active' : '' }}">
            <span class="nav-icon">📚</span> Katalog Buku
        </a>

        @unless(auth()->user()->isAdmin())
            <a href="{{ route('riwayat.index') }}" class="{{ request()->routeIs('riwayat.index') ? 'active' : '' }}">
                <span class="nav-icon">📋</span> Riwayat Saya
            </a>
            <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <span class="nav-icon">👤</span> Edit Profil
            </a>
        @endunless

        @if(auth()->user()->isAdmin())
            <hr class="sidebar-divider">
            <a href="{{ route('peminjaman.index') }}" class="{{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
                <span class="nav-icon">🗂️</span> Kelola Peminjaman
            </a>
            <a href="{{ route('buku.create') }}" class="{{ request()->routeIs('buku.create') ? 'active' : '' }}">
                <span class="nav-icon">➕</span> Tambah Buku
            </a>
            <a href="{{ route('admin.akun.index') }}" class="{{ request()->routeIs('admin.akun.*') ? 'active' : '' }}">
                <span class="nav-icon">👥</span> Kelola Akun
            </a>
        @endif
    </nav>

    <div class="sidebar-bottom">
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-details">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <span class="user-role">{{ auth()->user()->role }}</span>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">🚪 Logout</button>
        </form>
    </div>
</aside>

<div class="main-content">
    <div class="topbar">
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-right">@yield('topbar-action')</div>
    </div>
    <div class="page-content">
        @if(session('success'))<div class="alert-success">✅ {{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert-error">❌ {{ session('error') }}</div>@endif
        @yield('content')
    </div>
</div>

@else
<div class="main-content" style="margin-left:0;width:100%">
    @if(!request()->routeIs('login') && !request()->routeIs('register'))
        <div class="guest-topbar">
            <a href="{{ route('buku.index') }}" class="guest-brand"><div class="icon">📚</div> Library App</a>
            <div class="guest-auth-links">
                <a href="{{ route('login') }}" class="link-login">Login</a>
                <a href="{{ route('register') }}" class="btn-register">Daftar</a>
            </div>
        </div>
        <div class="page-content">
            @if(session('success'))<div class="alert-success">✅ {{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert-error">❌ {{ session('error') }}</div>@endif
            @yield('content')
        </div>
    @else
        @if(session('success'))
            <div style="position:fixed;top:16px;right:16px;z-index:999;max-width:320px">
                <div class="alert-success">✅ {{ session('success') }}</div>
            </div>
        @endif
        @yield('content')
    @endif
</div>
@endauth

</body>
</html>