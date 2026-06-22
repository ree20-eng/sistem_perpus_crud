@extends('layouts.app')
@section('title', 'Katalog Buku')
@section('page-title', 'Katalog Buku')

@section('content')

{{-- FILTER --}}
<div class="card" style="margin-bottom:20px">
    <div style="padding:14px 18px">
        <form method="GET" action="{{ route('buku.index') }}" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari judul, pengarang, ISBN..."
                   class="form-control" style="max-width:280px">
            <select name="status" class="form-control" style="max-width:180px" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="ready" {{ request('status')==='ready'?'selected':'' }}>✅ Tersedia</option>
                <option value="habis" {{ request('status')==='habis'?'selected':'' }}>❌ Stok Habis</option>
            </select>
            <button type="submit" class="btn btn-primary">Cari</button>
            @if(request('cari')||request('status'))
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- GRID BUKU --}}
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px">
    @forelse($bukus as $buku)
        @php $pct = $buku->stok > 0 ? ($buku->stok_tersedia / $buku->stok * 100) : 0; @endphp
        <div class="buku-card">
            <div>
                <a href="{{ route('buku.show', $buku->id) }}" class="buku-judul">{{ $buku->judul }}</a>
                <div class="buku-pengarang">{{ $buku->pengarang }}</div>
                <div class="buku-meta" style="margin-top:6px">{{ $buku->penerbit }} • {{ $buku->tahun_terbit }}</div>
            </div>

            <div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:5px">
                    @if($buku->isReady())
                        <span class="badge badge-ready">✅ Tersedia</span>
                    @else
                        <span class="badge badge-habis">❌ Habis</span>
                    @endif
                    <span style="font-size:11px;color:var(--slate-400)">{{ $buku->stok_tersedia }}/{{ $buku->stok }} eks.</span>
                </div>
                <div class="stok-bar">
                    <div class="stok-fill" style="width:{{ $pct }}%;background:{{ $pct > 50 ? 'var(--emerald)' : ($pct > 20 ? 'var(--amber)' : 'var(--rose)') }}"></div>
                </div>
            </div>

            <div style="display:flex;gap:8px;margin-top:auto">
                <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-secondary btn-sm" style="flex:1;justify-content:center">Detail</a>

                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm" style="flex:1;justify-content:center">🔒 Login</a>
                @endguest

                @auth
                    @if(in_array($buku->id, $sedangDipinjamIds))
                        <button class="btn btn-secondary btn-sm" style="flex:1;cursor:not-allowed;opacity:.6" disabled>Sedang Dipinjam</button>
                    @elseif(!$buku->isReady())
                        <button class="btn btn-secondary btn-sm" style="flex:1;cursor:not-allowed;opacity:.5" disabled>Stok Habis</button>
                    @else
                        <button type="button" class="btn btn-primary btn-sm" style="flex:1"
                                onclick="openModal({{ $buku->id }}, '{{ addslashes($buku->judul) }}')">
                            📚 Pinjam
                        </button>
                    @endif
                @endauth
            </div>

            @auth
                @if(auth()->user()->isAdmin())
                    <div style="display:flex;gap:8px;border-top:1px solid var(--slate-100);padding-top:12px">
                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn-edit" style="flex:1;justify-content:center">Edit</a>
                        <form method="POST" action="{{ route('buku.destroy', $buku->id) }}" style="flex:1"
                              onsubmit="return confirm('Hapus buku ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete" style="width:100%;justify-content:center">Hapus</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    @empty
        <div class="empty-state" style="grid-column:1/-1">
            <div class="empty-state-icon">📭</div>
            <p>Tidak ada buku yang ditemukan.</p>
        </div>
    @endforelse
</div>

<div style="margin-top:20px">{{ $bukus->links() }}</div>

@auth
{{-- ═══ MODAL PILIH DURASI PINJAM ═══ --}}
<div id="modal-overlay" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-title">📚 Pinjam Buku</div>
        <div id="modal-judul" class="modal-subtitle"></div>

        <form id="modal-form" method="POST" action="">
            @csrf

            {{-- INFO TANGGAL HARI INI --}}
            <div style="background:var(--slate-50);border:1px solid var(--slate-200);border-radius:var(--radius-sm);padding:10px 14px;margin-bottom:16px;font-size:12px;color:var(--slate-500)">
                📅 Tanggal pinjam: <strong style="color:var(--navy)">{{ now()->translatedFormat('d F Y') }}</strong>
            </div>

            {{-- PILIH DURASI --}}
            <div class="form-group">
                <label class="form-label">Pilih Durasi Peminjaman</label>

                {{-- Tombol pilih hari 1-7 --}}
                <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:6px;margin-bottom:14px" id="durasi-grid">
                    @for($i = 1; $i <= 7; $i++)
                        <button type="button"
                                onclick="pilihDurasi({{ $i }})"
                                id="btn-durasi-{{ $i }}"
                                style="padding:10px 4px;border-radius:var(--radius-sm);border:1.5px solid var(--slate-200);background:white;cursor:pointer;font-size:13px;font-weight:600;color:var(--slate-500);font-family:'Inter',sans-serif;transition:all .15s">
                            {{ $i }}
                        </button>
                    @endfor
                </div>

                <input type="hidden" name="durasi_hari" id="input-durasi" value="7">
            </div>

            {{-- PREVIEW TENGGAT --}}
            <div class="tenggat-preview" id="tenggat-box">
                <div style="font-size:11px;color:#4338CA;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">Tenggat Pengembalian</div>
                <div class="tenggat-date" id="tenggat-text">—</div>
                <div style="font-size:11px;color:#6366F1;margin-top:4px" id="tenggat-desc">7 hari dari sekarang</div>
            </div>

            <div style="display:flex;gap:10px">
                <button type="submit" class="btn btn-primary" style="flex:1">✅ Konfirmasi Pinjam</button>
                <button type="button" class="btn btn-secondary" style="flex:1" onclick="closeModal()">Batal</button>
            </div>
        </form>
    </div>
</div>

<style>
.durasi-btn-active {
    background: var(--indigo) !important;
    color: white !important;
    border-color: var(--indigo) !important;
    box-shadow: 0 4px 10px rgba(99,102,241,0.35);
    transform: translateY(-2px);
}
</style>

<script>
let selectedDurasi = 7;

function openModal(id, judul) {
    document.getElementById('modal-judul').textContent = judul;
    document.getElementById('modal-form').action = '/buku/' + id + '/pinjam';
    document.getElementById('modal-overlay').style.display = 'flex';
    pilihDurasi(7); // default 7 hari
}

function closeModal() {
    document.getElementById('modal-overlay').style.display = 'none';
}

function pilihDurasi(hari) {
    selectedDurasi = hari;
    document.getElementById('input-durasi').value = hari;

    // Update tampilan tombol
    for (let i = 1; i <= 7; i++) {
        const btn = document.getElementById('btn-durasi-' + i);
        if (i === hari) {
            btn.classList.add('durasi-btn-active');
        } else {
            btn.classList.remove('durasi-btn-active');
        }
    }

    // Hitung tenggat
    const today = new Date();
    const tenggat = new Date(today);
    tenggat.setDate(tenggat.getDate() + hari);

    const opts = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    document.getElementById('tenggat-text').textContent = tenggat.toLocaleDateString('id-ID', opts);
    document.getElementById('tenggat-desc').textContent = hari + ' hari dari sekarang';
}

document.getElementById('modal-overlay').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endauth
@endsection