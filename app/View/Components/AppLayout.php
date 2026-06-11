<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('title')</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f5f7fb;
}

.sidebar{
    width:250px;
    height:100vh;
    position:fixed;
    background:linear-gradient(180deg,#2563eb,#1d4ed8);
    color:white;
    padding:25px;
}

.sidebar h3{
    font-weight:bold;
}

.sidebar a{
    color:white;
    text-decoration:none;
    display:block;
    padding:12px;
    margin-top:10px;
    border-radius:10px;
}

.sidebar a:hover{
    background:rgba(255,255,255,.15);
}

.content{
    margin-left:270px;
    padding:30px;
}

.card-modern{
    border:none;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

</style>

</head>
<body>

<div class="sidebar">

    <h3>📚 Library App</h3>

    <hr>

    <a href="{{ route('peminjaman.index') }}">
        Dashboard
    </a>

    <a href="{{ route('peminjaman.create') }}">
        Tambah Data
    </a>

</div>

<div class="content">

    @yield('content')

</div>

</body>
</html>