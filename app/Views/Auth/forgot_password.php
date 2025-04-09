<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Kata Sandi</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<form method="post" action="/forgot-password">
    <h2 style="text-align:center; margin-bottom:20px;">Lupa Kata Sandi</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="error"><?= session()->getFlashdata('error') ?></p>
    <?php elseif (session()->getFlashdata('success')): ?>
        <p class="success"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <input type="email" name="email" placeholder="Masukkan Email Anda" required><br>
    <button type="submit">Kirim Link Reset</button>

    <div style="text-align:center; margin-top:15px;">
        <a href="/login" style="font-size: 0.9em;">Kembali ke Login</a>
    </div>
</form>

</body>
</html>
