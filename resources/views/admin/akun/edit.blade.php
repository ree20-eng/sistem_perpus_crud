@extends('layouts.app')

@section('title', 'Edit Akun')
@section('page-title', 'Edit Akun Pengguna')

@section('content')
<div class="card" style="max-width:520px">
    <div class="card-header"><span class="card-title">✏️ Edit Akun: {{ $akun->name }}</span></div>
    <div style="padding:24px">
        @if($errors->any())
            <div class="alert-error">@foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach</div>
        @endif

        <form method="POST" action="{{ route('admin.akun.update', $akun->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $akun->name) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $akun->email) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Nomor Identitas <span style="color:#9ca3af;font-weight:400">hanya angka</span></label>
                <input type="text" name="identitas" value="{{ old('identitas', $akun->identitas) }}" class="form-control"
                       inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
            </div>

            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    <option value="User" {{ old('role', $akun->role) == 'User' ? 'selected' : '' }}>User</option>
                    <option value="Admin" {{ old('role', $akun->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <hr style="border:none;border-top:1px solid #f1f5f9;margin:20px 0">

            <div class="form-group">
                <label class="form-label">Reset Password <span style="color:#9ca3af;font-weight:400">(kosongkan jika tidak ingin mengubah)</span></label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
            </div>

            <div style="display:flex;gap:10px;margin-top:8px">
                <button type="submit" class="btn-save">💾 Simpan</button>
                <a href="{{ route('admin.akun.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
