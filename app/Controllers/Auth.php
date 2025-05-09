<?php

namespace App\Controllers;

use App\Models\UserModel;
use Google_Client;
use Google_Service_Oauth2;
use CodeIgniter\Email\Email;

class Auth extends BaseController {
    public function register() {
        return view('Auth/register');
    }

    public function process_register() {
        $model = new UserModel();
        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];
        $model->save($data);
        return redirect()->to('/login');
    }

    public function login() {
        return view('Auth/login');
    }

    public function process_login() {
        $model = new UserModel();
        $user = $model->where('email', $this->request->getPost('email'))->first();

        if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
            session()->set('user', $user);
            return redirect()->to('/dashboard');
        }

        return redirect()->back()->with('error', 'Login gagal');
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }
    public function setPassword()
{
    $user = session()->get('user');
    if (!$user) return redirect()->to('/login');

    return view('auth/set_password');
}

public function savePassword()
{
    $user = session()->get('user');
    if (!$user) return redirect()->to('/login');

    $password = $this->request->getPost('password');
    $konfirmasi = $this->request->getPost('konfirmasi');

    if ($password !== $konfirmasi) {
        return redirect()->back()->with('error', 'Konfirmasi tidak cocok');
    }

    $model = new \App\Models\UserModel();
    $model->update($user['id'], [
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ]);

    $updatedUser = $model->find($user['id']);
    session()->set('user', $updatedUser);

    return redirect()->to('/dashboard');
}

public function forgotPasswordForm()
{
    return view('auth/forgot_password');
}

public function sendResetToken()
{
    $email = $this->request->getPost('email');
    $model = new UserModel();
    $user = $model->where('email', $email)->first();

    if (!$user) {
        return redirect()->back()->with('error', 'Email tidak ditemukan');
    }

    // Generate token & expiry
    $token = bin2hex(random_bytes(32));
    $expire = date('Y-m-d H:i:s', time() + 3600); // 1 jam

    // Simpan token
    $model->update($user['id'], [
        'reset_token' => $token,
        'reset_token_expired_at' => $expire
    ]);

    // Kirim email
    $emailService = \Config\Services::email();
    $resetLink = base_url('/reset-password?token=' . $token);
    $emailService->setTo($email);
    $emailService->setSubject('Reset Password Anda - TaskTim');
    $emailService->setMessage("Klik link berikut untuk mengatur ulang password Anda:<br><a href=\"$resetLink\">$resetLink</a>");

    if (!$emailService->send()) {
        return redirect()->back()->with('error', 'Gagal mengirim email. Coba lagi.');
    }

    return redirect()->to('/login')->with('success', 'Email reset sudah dikirim!');
}

public function resetPasswordForm()
{
    $token = $this->request->getGet('token');
    $model = new UserModel();
    $user = $model->where('reset_token', $token)
                  ->where('reset_token_expired_at >=', date('Y-m-d H:i:s'))
                  ->first();

    if (!$user) {
        return redirect()->to('/login')->with('error', 'Token tidak valid atau sudah kadaluarsa.');
    }

    return view('auth/reset_password', ['token' => $token]);
}

public function updatePasswordFromToken()
{
    $token = $this->request->getPost('token');
    $password = $this->request->getPost('password');
    $konfirmasi = $this->request->getPost('konfirmasi');

    if ($password !== $konfirmasi) {
        return redirect()->back()->with('error', 'Konfirmasi password tidak cocok');
    }

    $model = new UserModel();
    $user = $model->where('reset_token', $token)
                  ->where('reset_token_expired_at >=', date('Y-m-d H:i:s'))
                  ->first();

    if (!$user) {
        return redirect()->to('/login')->with('error', 'Token tidak valid atau sudah kadaluarsa.');
    }

    $model->update($user['id'], [
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'reset_token' => null,
        'reset_token_expired_at' => null
    ]);

    return redirect()->to('/login')->with('success', 'Password berhasil diubah.');
}
public function kirimUndangan()
{
    $email = $this->request->getPost('email');

    $emailService = \Config\Services::email();
    $registerLink = base_url('/register');

    $emailService->setTo($email);
    $emailService->setFrom('adhityabagus509@gmail.com', 'TaskTim App');
    $emailService->setSubject('Undangan Mendaftar di TaskTim');
    $emailService->setMailType('html'); // ⬅️ Ini WAJIB agar HTML tampil

    $emailContent = '
        <p>Halo,</p>
        <p>Kamu diundang untuk bergabung ke aplikasi <strong>TaskTim</strong>.</p>
        <p>Silakan klik tombol di bawah ini untuk mendaftar:</p>
        <p>
            <a href="' . $registerLink . '" style="background-color:#28a745;padding:10px 20px;color:white;text-decoration:none;border-radius:5px;">
                Daftar Sekarang
            </a>
        </p>
        <p>Jika kamu merasa tidak berkaitan, abaikan email ini.</p>
    ';

    $emailService->setMessage($emailContent);

    if ($emailService->send()) {
        return redirect()->back()->with('success', 'Undangan berhasil dikirim ke email.');
    } else {
        return redirect()->back()->with('error', nl2br($emailService->printDebugger(['headers', 'subject', 'body'])));
    }
}

}