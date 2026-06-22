<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileIdentitasController extends Controller
{
    public function edit()
    {
        return view('profile.edit-identitas');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'identitas' => ['required', 'numeric', 'digits_between:5,20'],
            'password'  => ['nullable', 'confirmed', 'min:8'],
        ], [
            'identitas.numeric' => 'Nomor identitas hanya boleh berisi angka.',
            'identitas.digits_between' => 'Nomor identitas harus 5-20 digit angka.',
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