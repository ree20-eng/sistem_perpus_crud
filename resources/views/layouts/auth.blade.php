<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-600 to-blue-900 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white">📚 Perpustakaan</h1>
            <p class="text-blue-200 mt-1 text-sm">Sistem Pencatatan Peminjaman Buku</p>
        </div>
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            @yield('content')
        </div>
    </div>
</body>
</html>
