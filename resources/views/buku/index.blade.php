@extends('layouts.app')

@section('title', 'Master Buku')
@section('page-title', 'Master Data Buku')

@section('topbar-action')
    <a href="{{ route('buku.create') }}" class="btn-primary">+ Tambah Buku</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <span class="card-title">📚 Daftar Buku</span>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Dipinjam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bukus as $buku)
                    <tr>
                        <td>{{ ($bukus->currentPage() - 1) * $bukus->perPage() + $loop->iteration }}</td>
                        <td style="font-weight:600">{{ $buku->judul }}</td>
                        <td>{{ $buku->pengarang }}</td>
                        <td style="color:#64748b">{{ $buku->penerbit }}</td>
                        <td>{{ $buku->tahun_terbit }}</td>
                        <td><span class="badge" style="background:#dbeafe;color:#1e40af">{{ $buku->stok }}</span></td>
                        <td><span class="badge" style="background:#f1f5f9;color:#475569">{{ $buku->peminjaman_count }}x</span></td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <a href="{{ route('buku.edit', $buku->id) }}" class="btn-edit">Edit</a>
                                <form method="POST" action="{{ route('buku.destroy', $buku->id) }}"
                                      onsubmit="return confirm('Hapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="empty-state">Belum ada data buku.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div style="margin-top:16px">{{ $bukus->links() }}</div>
@endsection
