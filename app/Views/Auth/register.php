<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - TaskTim</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<form method="post" action="/register">
    <h2>Daftar Akun TaskTim</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="error"><?= session()->getFlashdata('error') ?></p>
    <?php elseif (session()->getFlashdata('success')): ?>
        <p class="success"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <input type="text" class="form-input" name="nama" placeholder="Nama Lengkap"><br>
    <input type="email" name="email" placeholder="Email" class="form-control" required><br>
    <input type="password" name="password" placeholder="Kata Sandi" class="form-control" required><br>

    <button type="submit" class="btn">Daftar</button>

    <div style="text-align:center; margin-top:15px;">
        <a href="/login">Sudah punya akun? Masuk di sini</a>
    </div>
</form>


</body>
</html>
