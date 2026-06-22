@extends('layouts.app')

@section('title', 'Riwayat Pinjam - ' . $akun->name)
@section('page-title', 'Riwayat Pinjam Akun')

@section('content')
<a href="{{ route('admin.akun.index') }}" style="display:inline-flex;align-items:center;gap:4px;margin-bottom:16px;color:#1565C0;font-size:13px;text-decoration:none;font-weight:500">
    ← Kembali ke Kelola Akun
</a>

<div class="card" style="margin-bottom:16px">
    <div style="padding:20px 24px;display:flex;align-items:center;gap:14px">
        <div class="user-avatar" style="background:#1565C0;width:48px;height:48px;font-size:18px">
            {{ strtoupper(substr($akun->name, 0, 1)) }}
        </div>
        <div>
            <div style="font-size:16px;font-weight:700;color:#1e293b">{{ $akun->name }}</div>
            <div style="font-size:13px;color:#64748b">{{ $akun->email }} • Identitas: {{ $akun->identitas ?: '-' }}</div>
        </div>
        <span class="badge" style="margin-left:auto;background:{{ $akun->role === 'Admin' ? '#dbeafe' : '#f1f5f9' }};color:{{ $akun->role === 'Admin' ? '#1e40af' : '#475569' }}">
            {{ $akun->role }}
        </span>
    </div>
</div>

<div class="card">
    <div class="card-header"><span class="card-title">📚 Buku yang Dipinjam / Pernah Dipinjam</span></div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Tgl. Pinjam</th>
                    <th>Tenggat Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $item)
                    @php
                        $terlambat = $item->status === 'Dipinjam' && \Carbon\Carbon::parse($item->tenggat_kembali)->isPast();
                    @endphp
                    <tr>
                        <td>{{ ($riwayat->currentPage() - 1) * $riwayat->perPage() + $loop->iteration }}</td>
                        <td style="font-weight:600">{{ $item->buku?->judul ?? '-' }}</td>
                        <td style="color:#64748b">{{ $item->buku?->pengarang ?? '-' }}</td>
                        <td>{{ $item->tanggal_pinjam }}</td>
                        <td>
                            {{ $item->tenggat_kembali }}
                            @if($terlambat)
                                <span class="badge" style="background:#fee2e2;color:#991b1b;margin-left:4px">Terlambat</span>
                            @endif
                        </td>
                        <td>
                            @if($item->status === 'Dipinjam')
                                <span class="badge badge-dipinjam">Dipinjam</span>
                            @else
                                <span class="badge badge-kembali">Dikembalikan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty-state">Akun ini belum pernah meminjam buku apapun.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div style="margin-top:16px">{{ $riwayat->links() }}</div>
@endsection
