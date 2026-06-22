<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\PeminjamanBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();

        if ($request->filled('status')) {
            if ($request->status === 'ready') {
                $query->where('stok_tersedia', '>', 0);
            } elseif ($request->status === 'habis') {
                $query->where('stok_tersedia', '<=', 0);
            }
        }

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->cari . '%')
                  ->orWhere('pengarang', 'like', '%' . $request->cari . '%')
                  ->orWhere('isbn', 'like', '%' . $request->cari . '%');
            });
        }

        $bukus = $query->orderBy('judul')->paginate(10)->withQueryString();

        $sedangDipinjamIds = [];
        if (Auth::check()) {
            $sedangDipinjamIds = PeminjamanBuku::where('user_id', Auth::id())
                ->where('status', 'Dipinjam')
                ->pluck('buku_id')
                ->toArray();
        }

        return view('buku.index', compact('bukus', 'sedangDipinjamIds'));
    }

    /**
     * Halaman detail bibliografi 1 buku — bisa diakses publik.
     */
    public function show(Buku $buku)
    {
        $sedangDipinjam = false;
        if (Auth::check()) {
            $sedangDipinjam = Auth::user()->sedangMeminjam($buku->id);
        }

        return view('buku.show', compact('buku', 'sedangDipinjam'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'          => 'required|string|max:255',
            'edisi'          => 'nullable|string|max:50',
            'cetakan'        => 'nullable|string|max:50',
            'pengarang'      => 'required|string|max:255',
            'kota_terbit'    => 'nullable|string|max:100',
            'penerbit'       => 'required|string|max:255',
            'tahun_terbit'   => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'jumlah_halaman' => 'nullable|integer|min:1',
            'ukuran_tinggi'  => 'nullable|string|max:20',
            'isbn'           => 'nullable|string|max:30',
            'stok'           => 'required|integer|min:1',
        ]);

        $validated['stok_tersedia'] = $validated['stok'];

        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil ditambahkan!');
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul'          => 'required|string|max:255',
            'edisi'          => 'nullable|string|max:50',
            'cetakan'        => 'nullable|string|max:50',
            'pengarang'      => 'required|string|max:255',
            'kota_terbit'    => 'nullable|string|max:100',
            'penerbit'       => 'required|string|max:255',
            'tahun_terbit'   => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'jumlah_halaman' => 'nullable|integer|min:1',
            'ukuran_tinggi'  => 'nullable|string|max:20',
            'isbn'           => 'nullable|string|max:30',
            'stok'           => 'required|integer|min:1',
        ]);

        $selisih = $validated['stok'] - $buku->stok;
        $validated['stok_tersedia'] = max(0, $buku->stok_tersedia + $selisih);

        $buku->update($validated);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Data buku berhasil dihapus!');
    }
}