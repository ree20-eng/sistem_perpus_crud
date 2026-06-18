@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')
@section('page-title', 'Riwayat Peminjaman Saya')

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title">📋 Riwayat Peminjaman Anda</span>
    </div>
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $item)
                    @php
                        $terlambat = $item->isDipinjam() && \Carbon\Carbon::parse($item->tenggat_kembali)->isPast();
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
                        <td>
                            @if($item->status === 'Dipinjam')
                                <form method="POST" action="{{ route('riwayat.kembalikan', $item->id) }}"
                                      onsubmit="return confirm('Tandai buku ini sebagai sudah dikembalikan?')">
                                    @csrf
                                    <button type="submit" class="btn-save" style="padding:5px 12px;font-size:12px">
                                        ✅ Kembalikan
                                    </button>
                                </form>
                            @else
                                <span style="color:#9ca3af;font-size:12px">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty-state">Anda belum pernah meminjam buku. <a href="{{ route('buku.index') }}" style="color:#1565C0">Lihat katalog buku</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div style="margin-top:16px">{{ $riwayat->links() }}</div>
@endsection
