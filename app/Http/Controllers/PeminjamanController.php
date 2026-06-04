<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $data = Peminjaman::latest()->get();

        return view('peminjaman.index', compact('data'));
    }

    public function create()
    {
        return view('peminjaman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required|max:100',
            'identitas' => 'required|max:50',
            'judul_buku' => 'required|max:255',
            'tanggal_pinjam' => 'required|date',
            'tenggat_kembali' => 'required|date',
            'status' => 'required'
        ]);

        Peminjaman::create($request->all());

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(Peminjaman $peminjaman)
    {
        return view('peminjaman.edit', compact('peminjaman'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'nama_peminjam' => 'required|max:100',
            'identitas' => 'required|max:50',
            'judul_buku' => 'required|max:255',
            'tanggal_pinjam' => 'required|date',
            'tenggat_kembali' => 'required|date',
            'status' => 'required'
        ]);

        $peminjaman->update($request->all());

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Data berhasil dihapus');
    }
}