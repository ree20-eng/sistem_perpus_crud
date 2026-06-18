<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileIdentitasController extends Controller
{
    /**
     * Tampilkan halaman edit profile (nama, email, identitas, password).
     */
    public function edit()
    {
        return view('profile.edit-identitas');
    }

    /**
     * Update data profile milik user yang login.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'identitas' => ['required', 'string', 'max:50'],
            'password'  => ['nullable', 'confirmed', 'min:8'],
        ]);

        $user->name      = $validated['name'];
        $user->email     = $validated['email'];
        $user->identitas = $validated['identitas'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}