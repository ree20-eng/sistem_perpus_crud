@extends('layouts.app')

@section('title', 'Kelola Akun')
@section('page-title', 'Kelola Akun Pengguna')

@section('content')
<div class="card" style="margin-bottom:16px">
    <div style="padding:16px 20px">
        <form method="GET" action="{{ route('admin.akun.index') }}" style="display:flex;gap:10px">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama, email, atau identitas..."
                   class="form-control" style="max-width:300px">
            <button type="submit" class="btn-save" style="padding:9px 18px">Cari</button>
            @if(request('cari'))
                <a href="{{ route('admin.akun.index') }}" class="btn-cancel" style="padding:9px 18px">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header"><span class="card-title">👥 Daftar Akun</span></div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Identitas</th>
                    <th>Role</th>
                    <th>Sedang Dipinjam</th>
                    <th>Total Riwayat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($akun as $item)
                    <tr>
                        <td>{{ ($akun->currentPage() - 1) * $akun->perPage() + $loop->iteration }}</td>
                        <td style="font-weight:600">{{ $item->name }}</td>
                        <td style="color:#64748b">{{ $item->email }}</td>
                        <td>{{ $item->identitas ?: '-' }}</td>
                        <td>
                            @if($item->role === 'Admin')
                                <span class="badge" style="background:#dbeafe;color:#1e40af">Admin</span>
                            @else
                                <span class="badge" style="background:#f1f5f9;color:#475569">User</span>
                            @endif
                        </td>
                        <td>
                            @if($item->sedang_dipinjam_count > 0)
                                <span class="badge badge-dipinjam">{{ $item->sedang_dipinjam_count }} buku</span>
                            @else
                                <span style="color:#9ca3af;font-size:12px">Tidak ada</span>
                            @endif
                        </td>
                        <td>{{ $item->peminjaman_count }}x</td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <a href="{{ route('admin.akun.show', $item->id) }}" class="btn-cancel" style="padding:5px 12px;font-size:12px">Lihat Buku</a>
                                <a href="{{ route('admin.akun.edit', $item->id) }}" class="btn-edit">Edit</a>
                                @if($item->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.akun.destroy', $item->id) }}"
                                          onsubmit="return confirm('Hapus akun ini? Data peminjaman terkait akan tetap tersimpan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="empty-state">Belum ada akun terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div style="margin-top:16px">{{ $akun->links() }}</div>
@endsection