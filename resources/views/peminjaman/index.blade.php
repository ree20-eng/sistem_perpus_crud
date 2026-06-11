@extends('layouts.app')

@section('title', 'Daftar Peminjaman')
@section('page-title', 'Data Peminjaman Buku')

@section('topbar-action')
    <a href="{{ route('peminjaman.create') }}" class="btn-primary">+ Tambah Data</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title">📋 Daftar Peminjaman Buku</span>
        <small style="color:#64748b;font-size:12px">Kelola data peminjaman perpustakaan</small>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Identitas</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Tgl. Pinjam</th>
                    <th>Tenggat Kembali</th>
                    <th>Status</th>
                    <th>Foto Identitas</th>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <th>Aksi</th>
                        @endif
                    @endauth
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $item)
                    <tr>
                        <td>{{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}</td>
                        <td style="font-weight:600">{{ $item->nama_peminjam }}</td>
                        <td>{{ $item->identitas }}</td>
                        <td>{{ $item->buku?->judul ?? '-' }}</td>
                        <td style="color:#64748b">{{ $item->buku?->pengarang ?? '-' }}</td>
                        <td>{{ $item->tanggal_pinjam }}</td>
                        <td>{{ $item->tenggat_kembali }}</td>
                        <td>
                            @if($item->status === 'Dipinjam')
                                <span class="badge badge-dipinjam">Dipinjam</span>
                            @else
                                <span class="badge badge-kembali">Dikembalikan</span>
                            @endif
                        </td>
                        <td>
                            @if($item->foto_identitas)
                                @php $ext = pathinfo($item->foto_identitas, PATHINFO_EXTENSION); @endphp
                                @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                                    <a href="{{ Storage::url($item->foto_identitas) }}" target="_blank">
                                        <img src="{{ Storage::url($item->foto_identitas) }}" style="width:40px;height:40px;object-fit:cover;border-radius:6px;border:1px solid #e2e8f0">
                                    </a>
                                @else
                                    <a href="{{ Storage::url($item->foto_identitas) }}" target="_blank" style="color:#1565C0;font-size:12px">📄 PDF</a>
                                @endif
                            @else
                                <span style="color:#9ca3af;font-size:12px">-</span>
                            @endif
                        </td>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <td>
                                    <div style="display:flex;gap:6px">
                                        <a href="{{ route('peminjaman.edit', $item->id) }}" class="btn-edit">Edit</a>
                                        <form method="POST" action="{{ route('peminjaman.destroy', $item->id) }}"
                                              onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        @endauth
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="empty-state">Belum ada data peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div style="margin-top:16px">{{ $peminjaman->links() }}</div>
@endsection
