<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\PeminjamanBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeminjamanBukuController extends Controller
{
    /**
     * Tampilkan daftar peminjaman dengan eager loading relasi buku.
     * Halaman ini bersifat publik (bisa dilihat siapa saja).
     */
    public function index()
    {
        // Eager Loading: ambil data peminjaman beserta data buku terkait sekaligus
        $peminjaman = PeminjamanBuku::with('buku')->latest()->paginate(10);

        return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * Tampilkan form tambah peminjaman (hanya Admin).
     */
    public function create()
    {
        $bukus = Buku::orderBy('judul')->get();

        return view('peminjaman.create', compact('bukus'));
    }

    /**
     * Simpan data peminjaman baru beserta file foto identitas (hanya Admin).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_peminjam'  => 'required|string|max:255',
            'identitas'      => 'required|string|max:50',
            'buku_id'        => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tenggat_kembali'=> 'required|date|after_or_equal:tanggal_pinjam',
            'status'         => 'required|in:Dipinjam,Sudah Dikembalikan',
            'foto_identitas' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Proses upload file foto identitas
        if ($request->hasFile('foto_identitas')) {
            $path = $request->file('foto_identitas')->store('foto_identitas', 'public');
            $validated['foto_identitas'] = $path;
        }

        PeminjamanBuku::create($validated);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit peminjaman (hanya Admin).
     */
    public function edit(PeminjamanBuku $peminjaman)
    {
        $bukus = Buku::orderBy('judul')->get();

        return view('peminjaman.edit', compact('peminjaman', 'bukus'));
    }

    /**
     * Perbarui data peminjaman, ganti foto jika ada file baru (hanya Admin).
     */
    public function update(Request $request, PeminjamanBuku $peminjaman)
    {
        $validated = $request->validate([
            'nama_peminjam'  => 'required|string|max:255',
            'identitas'      => 'required|string|max:50',
            'buku_id'        => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tenggat_kembali'=> 'required|date|after_or_equal:tanggal_pinjam',
            'status'         => 'required|in:Dipinjam,Sudah Dikembalikan',
            'foto_identitas' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Ganti foto lama dengan yang baru jika ada file baru diupload
        if ($request->hasFile('foto_identitas')) {
            // Hapus file lama jika ada
            if ($peminjaman->foto_identitas) {
                Storage::disk('public')->delete($peminjaman->foto_identitas);
            }
            $path = $request->file('foto_identitas')->store('foto_identitas', 'public');
            $validated['foto_identitas'] = $path;
        }

        $peminjaman->update($validated);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    /**
     * Hapus data peminjaman beserta file fotonya (hanya Admin).
     */
    public function destroy(PeminjamanBuku $peminjaman)
    {
        // Hapus file foto dari storage jika ada
        if ($peminjaman->foto_identitas) {
            Storage::disk('public')->delete($peminjaman->foto_identitas);
        }

        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus!');
    }
}
