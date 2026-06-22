<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\PeminjamanBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PeminjamanMandiriController extends Controller
{
    /**
     * User memilih durasi pinjam (1-7 hari).
     * Tanggal pinjam = hari ini.
     * Tenggat kembali = hari ini + durasi yang dipilih.
     */
    public function pinjam(Request $request, Buku $buku)
    {
        $user = Auth::user();

        $request->validate([
            'durasi_hari' => ['required', 'integer', 'min:1', 'max:7'],
        ], [
            'durasi_hari.required' => 'Pilih durasi peminjaman.',
            'durasi_hari.min'      => 'Durasi minimal 1 hari.',
            'durasi_hari.max'      => 'Durasi maksimal 7 hari.',
        ]);

        if (empty($user->identitas)) {
            return redirect()->route('profile.edit')
                ->with('error', 'Lengkapi nomor identitas (NIM/NIP/KTP) di profil Anda sebelum meminjam buku.');
        }

        if (!$buku->isReady()) {
            return back()->with('error', 'Maaf, stok buku ini sedang habis.');
        }

        if ($user->sedangMeminjam($buku->id)) {
            return back()->with('error', 'Anda masih memiliki peminjaman aktif untuk buku ini.');
        }

        $durasi         = (int) $request->durasi_hari;
        $tanggalPinjam  = Carbon::today()->format('Y-m-d');
        $tenggatKembali = Carbon::today()->addDays($durasi)->format('Y-m-d');
        $tenggatFormatted = Carbon::today()->addDays($durasi)->translatedFormat('d F Y');

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
            ->with('success', "Berhasil meminjam \"{$buku->judul}\" selama {$durasi} hari. Harap kembalikan sebelum {$tenggatFormatted}.");
    }

    public function kembalikan(PeminjamanBuku $peminjaman)
    {
        $user = Auth::user();

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

    public function riwayat()
    {
        $riwayat = PeminjamanBuku::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('peminjaman.riwayat', compact('riwayat'));
    }
}