@extends('layouts.app')

@section('title', 'Kelola Peminjaman')
@section('page-title', 'Kelola Data Peminjaman')

@section('topbar-action')
    <a href="{{ route('peminjaman.create') }}" class="btn-primary">+ Tambah Data</a>
@endsection

@section('content')

<div class="card" style="margin-bottom:16px">
    <div style="padding:16px 20px">
        <form method="GET" action="{{ route('peminjaman.index') }}" style="display:flex;gap:10px;flex-wrap:wrap">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama peminjam..."
                   class="form-control" style="max-width:260px">

            <select name="status" class="form-control" style="max-width:200px" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="Dipinjam" {{ request('status') === 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="Sudah Dikembalikan" {{ request('status') === 'Sudah Dikembalikan' ? 'selected' : '' }}>Sudah Dikembalikan</option>
            </select>

            <button type="submit" class="btn-save" style="padding:9px 18px">Cari</button>
            @if(request('cari') || request('status'))
                <a href="{{ route('peminjaman.index') }}" class="btn-cancel" style="padding:9px 18px">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title">🗂️ Daftar Peminjaman (Semua Sumber)</span>
        <small style="color:#64748b;font-size:12px">Termasuk peminjaman mandiri oleh User & input manual Admin</small>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Identitas</th>
                    <th>Judul Buku</th>
                    <th>Tgl. Pinjam</th>
                    <th>Tenggat Kembali</th>
                    <th>Status</th>
                    <th>Sumber</th>
                    <th>Foto Identitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $item)
                    <tr>
                        <td>{{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}</td>
                        <td style="font-weight:600">{{ $item->nama_peminjam }}</td>
                        <td>{{ $item->identitas }}</td>
                        <td>{{ $item->buku?->judul ?? '-' }}</td>
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
                            @if($item->user_id)
                                <span class="badge" style="background:#e0e7ff;color:#3730a3">Mandiri (User)</span>
                            @else
                                <span class="badge" style="background:#f1f5f9;color:#475569">Input Admin</span>
                            @endif
                        </td>
                        <td>
                            @if($item->foto_identitas)
                                @php $ext = pathinfo($item->foto_identitas, PATHINFO_EXTENSION); @endphp
                                @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                                    <a href="{{ Storage::url($item->foto_identitas) }}" target="_blank">
                                        <img src="{{ Storage::url($item->foto_identitas) }}" style="width:36px;height:36px;object-fit:cover;border-radius:6px">
                                    </a>
                                @else
                                    <a href="{{ Storage::url($item->foto_identitas) }}" target="_blank" style="color:#1565C0;font-size:12px">📄 PDF</a>
                                @endif
                            @else
                                <span style="color:#9ca3af;font-size:12px">-</span>
                            @endif
                        </td>
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
                    </tr>
                @empty
                    <tr><td colspan="10" class="empty-state">Belum ada data peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div style="margin-top:16px">{{ $peminjaman->links() }}</div>
@endsection