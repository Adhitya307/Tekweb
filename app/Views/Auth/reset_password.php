<h2>Atur Ulang Kata Sandi</h2>
<form method="post" action="/reset-password">
    <input type="hidden" name="token" value="<?= esc($token) ?>">
    <input type="password" name="password" placeholder="Password Baru" required><br>
    <input type="password" name="konfirmasi" placeholder="Konfirmasi Password" required><br>
    <button type="submit">Reset Password</button>
</form>
