<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - TaskTim</title>
</head>
<body>
    <h1>Selamat Datang di Dashboard, <?= esc($user['nama']) ?>!</h1>

    <p>Ini adalah dashboard sederhana untuk melihat dan mengelola tugas tim.</p>

    <ul>
        <li><a href="#">Lihat Daftar Tugas</a></li>
        <li><a href="#">Tambah Tugas Baru</a></li>
        <li><a href="#">Profil Saya</a></li>
    </ul>

    <a href="/logout">Logout</a>
</body>
</html>
