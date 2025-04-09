<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - TaskTim</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<form method="post" action="/login">
    <h2 style="text-align:center; margin-bottom:20px;">Login ke TaskTim</h2>

    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Sandi" required><br>

    <button type="submit">Masuk</button>

    <div style="text-align:center; margin-top:15px;">
    <a href="/forgot-password" style="font-size: 0.9em;">Lupa sandi?</a><br>
        <a href="/register" style="font-size: 0.9em;">Belum punya akun? Daftar</a><br><br>
        
        <a href="/google-login" class="google-btn">Masuk dengan Google</a>

    </div>
</form>

</body>
</html>
