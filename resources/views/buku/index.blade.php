@extends('layouts.app')

@section('title', 'Daftar Buku')
@section('page-title', 'Katalog Buku Perpustakaan')

@section('topbar-action')
    @auth
        <a href="{{ route('riwayat.index') }}" class="btn-cancel" style="margin-right:8px">📋 Riwayat Saya</a>
    @endauth
    @auth
        @if(auth()->user()->isAdmin())
            <a href="{{ route('buku.create') }}" class="btn-primary">+ Tambah Buku</a>
        @endif
    @endauth
@endsection

@section('content')

{{-- FILTER BAR --}}
<div class="card" style="margin-bottom:16px">
    <div style="padding:16px 20px">
        <form method="GET" action="{{ route('buku.index') }}" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari judul atau pengarang..."
                   class="form-control" style="max-width:260px">

            <select name="status" class="form-control" style="max-width:180px" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="ready" {{ request('status') === 'ready' ? 'selected' : '' }}>✅ Ready Dipinjam</option>
                <option value="habis" {{ request('status') === 'habis' ? 'selected' : '' }}>❌ Stok Habis</option>
            </select>

            <button type="submit" class="btn-save" style="padding:9px 18px">Cari</button>

            @if(request('cari') || request('status'))
                <a href="{{ route('buku.index') }}" class="btn-cancel" style="padding:9px 18px">Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- GRID BUKU --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px">
    @forelse($bukus as $buku)
        <div class="card" style="padding:18px;display:flex;flex-direction:column;gap:10px">
            <div>
                <div style="font-weight:600;font-size:15px;color:#1e293b">{{ $buku->judul }}</div>
                <div style="font-size:13px;color:#64748b;margin-top:2px">{{ $buku->pengarang }}</div>
                <div style="font-size:12px;color:#94a3b8;margin-top:2px">{{ $buku->penerbit }} • {{ $buku->tahun_terbit }}</div>
            </div>

            <div style="display:flex;align-items:center;gap:8px">
                @if($buku->isReady())
                    <span class="badge badge-kembali">✅ Ready</span>
                @else
                    <span class="badge" style="background:#fee2e2;color:#991b1b">❌ Stok Habis</span>
                @endif
                <span style="font-size:12px;color:#64748b">
                    {{ $buku->stok_tersedia }} / {{ $buku->stok }} eksemplar tersedia
                </span>
            </div>

            {{-- TOMBOL AKSI --}}
            <div style="margin-top:auto;padding-top:8px">
                @guest
                    {{-- Belum login: hanya bisa lihat, diarahkan ke login jika klik pinjam --}}
                    <a href="{{ route('login') }}" class="btn-save" style="display:block;text-align:center;width:100%">
                        🔒 Login untuk Pinjam
                    </a>
                @endguest

                @auth
                    @if(in_array($buku->id, $sedangDipinjamIds))
                        <button class="btn-cancel" style="width:100%;cursor:not-allowed" disabled>
                            📖 Sedang Anda Pinjam
                        </button>
                    @elseif(!$buku->isReady())
                        <button class="btn-cancel" style="width:100%;cursor:not-allowed" disabled>
                            Stok Habis
                        </button>
                    @else
                        <form method="POST" action="{{ route('buku.pinjam', $buku->id) }}"
                              onsubmit="return confirm('Pinjam buku ini? Estimasi pengembalian 7 hari dari sekarang.')">
                            @csrf
                            <button type="submit" class="btn-save" style="width:100%">📚 Pinjam Buku</button>
                        </form>
                    @endif
                @endauth
            </div>

            {{-- AKSI ADMIN --}}
            @auth
                @if(auth()->user()->isAdmin())
                    <div style="display:flex;gap:6px;border-top:1px solid #f1f5f9;padding-top:10px">
                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn-edit" style="flex:1;text-align:center">Edit</a>
                        <form method="POST" action="{{ route('buku.destroy', $buku->id) }}"
                              onsubmit="return confirm('Hapus buku ini?')" style="flex:1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" style="width:100%">Hapus</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    @empty
        <div class="empty-state" style="grid-column:1/-1">Tidak ada buku yang ditemukan.</div>
    @endforelse
</div>

<div style="margin-top:20px">{{ $bukus->links() }}</div>
@endsection