@extends('layouts.app')
@section('title', $buku->judul)
@section('page-title', 'Detail Buku')

@section('content')
<a href="{{ route('buku.index') }}" style="display:inline-flex;align-items:center;gap:4px;margin-bottom:16px;color:var(--indigo);font-size:13px;text-decoration:none;font-weight:500">
    ← Kembali ke Katalog
</a>

<div class="card" style="max-width:760px">
    <div style="padding:28px 28px 0">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px">
            <div>
                <h2 style="font-size:22px;color:var(--navy);font-weight:800;line-height:1.3;letter-spacing:-0.02em">{{ $buku->judul }}</h2>
                <p style="font-size:14px;color:var(--slate-500);margin-top:4px">oleh <strong style="color:var(--slate-700)">{{ $buku->pengarang }}</strong></p>
            </div>
            @if($buku->isReady())
                <span class="badge badge-ready" style="font-size:12px;padding:5px 14px;flex-shrink:0">✅ Tersedia</span>
            @else
                <span class="badge badge-habis" style="font-size:12px;padding:5px 14px;flex-shrink:0">❌ Stok Habis</span>
            @endif
        </div>
    </div>

    <div style="padding:24px 28px">
        {{-- GRID BIBLIOGRAFI --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px 28px;padding:20px 0;border-top:1px solid var(--slate-100);border-bottom:1px solid var(--slate-100)">
            @php
                $fields = [
                    'Edisi'           => $buku->edisi,
                    'Cetakan'         => $buku->cetakan,
                    'Kota Terbit'     => $buku->kota_terbit,
                    'Penerbit'        => $buku->penerbit,
                    'Tahun Terbit'    => $buku->tahun_terbit,
                    'Jumlah Halaman'  => $buku->jumlah_halaman ? $buku->jumlah_halaman . ' halaman' : null,
                    'Ukuran Tinggi'   => $buku->ukuran_tinggi,
                    'ISBN'            => $buku->isbn,
                ];
            @endphp
            @foreach($fields as $label => $value)
                <div>
                    <div style="font-size:11px;color:var(--slate-400);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">{{ $label }}</div>
                    <div style="font-size:14px;color:{{ $value ? 'var(--slate-700)' : 'var(--slate-300)' }};font-weight:{{ $value ? '500' : '400' }}">
                        {{ $value ?: 'Tidak ada data' }}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- STOK INFO --}}
        <div style="padding:16px 0;margin-bottom:4px">
            @php $pct = $buku->stok > 0 ? ($buku->stok_tersedia / $buku->stok * 100) : 0; @endphp
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
                <span style="font-size:13px;color:var(--slate-500)">Ketersediaan Eksemplar</span>
                <span style="font-size:15px;font-weight:700;color:var(--navy)">
                    {{ $buku->stok_tersedia }}
                    <span style="color:var(--slate-400);font-weight:400;font-size:13px">/ {{ $buku->stok }}</span>
                </span>
            </div>
            <div class="stok-bar" style="height:6px">
                <div class="stok-fill" style="width:{{ $pct }}%;background:{{ $pct > 50 ? 'var(--emerald)' : ($pct > 20 ? 'var(--amber)' : 'var(--rose)') }}"></div>
            </div>
        </div>

        {{-- TOMBOL PINJAM --}}
        <div style="margin-top:20px">
            @guest
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg" style="width:100%;justify-content:center">
                    🔒 Login untuk Meminjam
                </a>
            @endguest

            @auth
                @if($sedangDipinjam)
                    <button class="btn btn-secondary btn-lg" style="width:100%;cursor:not-allowed;opacity:.7" disabled>📖 Sedang Anda Pinjam</button>
                @elseif(!$buku->isReady())
                    <button class="btn btn-secondary btn-lg" style="width:100%;cursor:not-allowed;opacity:.7" disabled>Stok Habis</button>
                @else
                    <button type="button" class="btn btn-primary btn-lg" style="width:100%" onclick="openModal()">
                        📚 Pinjam Buku Ini
                    </button>
                @endif
            @endauth
        </div>
    </div>
</div>

@auth
@if(!$sedangDipinjam && $buku->isReady())
<div id="modal-overlay" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-title">📚 Pinjam Buku</div>
        <div class="modal-subtitle">{{ $buku->judul }}</div>

        <form method="POST" action="{{ route('buku.pinjam', $buku->id) }}">
            @csrf

            <div style="background:var(--slate-50);border:1px solid var(--slate-200);border-radius:var(--radius-sm);padding:10px 14px;margin-bottom:16px;font-size:12px;color:var(--slate-500)">
                📅 Tanggal pinjam: <strong style="color:var(--navy)">{{ now()->translatedFormat('d F Y') }}</strong>
            </div>

            <div class="form-group">
                <label class="form-label">Pilih Durasi Peminjaman</label>
                <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:6px;margin-bottom:14px">
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

            <div class="tenggat-preview">
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
function openModal() {
    document.getElementById('modal-overlay').style.display = 'flex';
    pilihDurasi(7);
}
function closeModal() {
    document.getElementById('modal-overlay').style.display = 'none';
}
function pilihDurasi(hari) {
    document.getElementById('input-durasi').value = hari;
    for (let i = 1; i <= 7; i++) {
        document.getElementById('btn-durasi-' + i).classList.toggle('durasi-btn-active', i === hari);
    }
    const tenggat = new Date();
    tenggat.setDate(tenggat.getDate() + hari);
    const opts = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    document.getElementById('tenggat-text').textContent = tenggat.toLocaleDateString('id-ID', opts);
    document.getElementById('tenggat-desc').textContent = hari + ' hari dari sekarang';
}
document.getElementById('modal-overlay').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
window.addEventListener('DOMContentLoaded', () => pilihDurasi(7));
</script>
@endif
@endauth
@endsection