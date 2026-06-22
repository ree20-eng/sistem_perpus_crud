<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AkunController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->cari . '%')
                  ->orWhere('email', 'like', '%' . $request->cari . '%')
                  ->orWhere('identitas', 'like', '%' . $request->cari . '%');
            });
        }

        $akun = $query->withCount('peminjaman')
            ->withCount(['peminjaman as sedang_dipinjam_count' => function ($q) {
                $q->where('status', 'Dipinjam');
            }])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.akun.index', compact('akun'));
    }

    /**
     * Halaman detail 1 akun, menampilkan semua buku yang sedang/pernah dipinjam.
     */
    public function show(User $akun)
    {
        $riwayat = $akun->peminjaman()->with('buku')->latest()->paginate(10);

        return view('admin.akun.show', compact('akun', 'riwayat'));
    }

    public function edit(User $akun)
    {
        return view('admin.akun.edit', compact('akun'));
    }

    public function update(Request $request, User $akun)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', Rule::unique('users')->ignore($akun->id)],
            'identitas' => ['nullable', 'numeric', 'digits_between:5,20'],
            'role'      => ['required', 'in:Admin,User'],
            'password'  => ['nullable', 'min:8'],
        ], [
            'identitas.numeric' => 'Nomor identitas hanya boleh berisi angka.',
        ]);

        $akun->name      = $validated['name'];
        $akun->email     = $validated['email'];
        $akun->identitas = $validated['identitas'];
        $akun->role      = $validated['role'];

        if (!empty($validated['password'])) {
            $akun->password = Hash::make($validated['password']);
        }

        $akun->save();

        return redirect()->route('admin.akun.index')->with('success', 'Data akun berhasil diperbarui!');
    }

    public function destroy(User $akun)
    {
        if ($akun->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $akun->delete();

        return redirect()->route('admin.akun.index')->with('success', 'Akun berhasil dihapus!');
    }
}