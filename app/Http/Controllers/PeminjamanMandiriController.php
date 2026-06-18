<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\PeminjamanBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanMandiriController extends Controller
{
    /**
     * Proses peminjaman mandiri oleh user yang sedang login.
     * Data nama & identitas otomatis diambil dari akun (tidak perlu isi ulang).
     * Tenggat kembali otomatis = tanggal pinjam + 7 hari.
     */
    public function pinjam(Request $request, Buku $buku)
    {
        $user = Auth::user();

        // Validasi: identitas wajib sudah diisi di profil sebelum bisa pinjam
        if (empty($user->identitas)) {
            return redirect()->route('profile.edit')
                ->with('error', 'Lengkapi nomor identitas (NIM/NIP/KTP) di profil Anda sebelum meminjam buku.');
        }

        // Validasi: stok harus tersedia
        if (!$buku->isReady()) {
            return back()->with('error', 'Maaf, stok buku ini sedang habis.');
        }

        // Validasi: user tidak boleh pinjam buku yang sama 2x sebelum dikembalikan
        if ($user->sedangMeminjam($buku->id)) {
            return back()->with('error', 'Anda masih memiliki peminjaman aktif untuk buku ini.');
        }

        $tanggalPinjam  = now()->format('Y-m-d');
        $tenggatKembali = now()->addDays(7)->format('Y-m-d'); // estimasi 7 hari

        PeminjamanBuku::create([
            'user_id'         => $user->id,
            'nama_peminjam'   => $user->name,
            'identitas'       => $user->identitas,
            'buku_id'         => $buku->id,
            'tanggal_pinjam'  => $tanggalPinjam,
            'tenggat_kembali' => $tenggatKembali,
            'status'          => 'Dipinjam',
        ]);

        $buku->kurangiStok();

        return redirect()->route('riwayat.index')
            ->with('success', "Berhasil meminjam \"{$buku->judul}\". Harap kembalikan sebelum {$tenggatKembali}.");
    }

    /**
     * User mengembalikan buku miliknya sendiri.
     * Stok buku otomatis bertambah kembali.
     */
    public function kembalikan(PeminjamanBuku $peminjaman)
    {
        $user = Auth::user();

        // Pastikan hanya pemilik peminjaman yang bisa mengembalikan
        if ($peminjaman->user_id !== $user->id) {
            abort(403, 'Anda tidak berhak mengubah data peminjaman ini.');
        }

        if ($peminjaman->status === 'Sudah Dikembalikan') {
            return back()->with('error', 'Buku ini sudah ditandai dikembalikan sebelumnya.');
        }

        $peminjaman->update(['status' => 'Sudah Dikembalikan']);

        if ($peminjaman->buku) {
            $peminjaman->buku->tambahStok();
        }

        return back()->with('success', 'Buku berhasil ditandai sebagai dikembalikan. Terima kasih!');
    }

    /**
     * Halaman riwayat peminjaman milik user yang login.
     */
    public function riwayat()
    {
        $riwayat = PeminjamanBuku::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('peminjaman.riwayat', compact('riwayat'));
    }
}
