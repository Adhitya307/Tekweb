<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==========================
// AUTHENTICATION ROUTES
// ==========================
$routes->get('/', 'Auth::login'); // Halaman login (default)
$routes->get('/register', 'Auth::register'); // Form registrasi
$routes->post('/register', 'Auth::process_register'); // Proses registrasi
$routes->get('/login', 'Auth::login'); // Form login
$routes->post('/login', 'Auth::process_login'); // Proses login
$routes->get('/logout', 'Auth::logout'); // Logout

// ==========================
// DASHBOARD ROUTES
// ==========================
$routes->get('/dashboard', 'Dashboard::index'); // Halaman dashboard
$routes->post('/projects/create', 'Dashboard::create'); // Buat proyek baru dari dashboard

// ==========================
// GOOGLE AUTH ROUTES
// ==========================
$routes->get('/google-login', 'GoogleAuth::redirect'); // Redirect ke login Google
$routes->get('/google-callback', 'GoogleAuth::callback'); // Callback dari Google login

// ==========================
// PASSWORD MANAGEMENT ROUTES
// ==========================
$routes->get('/atur-password', 'Auth::setPassword'); // Form atur password awal
$routes->post('/atur-password', 'Auth::savePassword'); // Simpan password

$routes->get('/forgot-password', 'Auth::forgotPasswordForm'); // Form lupa password
$routes->post('/forgot-password', 'Auth::sendResetToken'); // Kirim token reset
$routes->get('/reset-password', 'Auth::resetPasswordForm'); // Form reset password
$routes->post('/reset-password', 'Auth::updatePasswordFromToken'); // Update password dengan token

// ==========================
// PROJECT ROUTES
// ==========================
$routes->get('project/(:num)', 'ProjectController::detail/$1'); // Tampilkan detail proyek (mungkin ini duplikat?)
$routes->get('project/(:num)/task/create', 'ProjectController::createTask/$1'); // Form tambah task
$routes->post('project/(:num)/task/store', 'ProjectController::storeTask/$1'); // Simpan task baru
$routes->get('project/(:num)', 'ProjectController::showProjectDetail/$1'); // Tampilkan detail proyek

// ==========================
// TASK ROUTES
// ==========================
$routes->get('task/(:num)', 'ProjectController::showTask/$1'); // Tampilkan detail task

// ==========================
// PROJECT ACTION ROUTES
// ==========================
$routes->post('/projects/invite', 'ProjectController::inviteMember'); // Undang anggota ke proyek
$routes->post('/kirim-undangan', 'Auth::kirimUndangan'); // Kirim undangan dari Auth
$routes->post('projects/update', 'ProjectController::update'); // Update proyek
$routes->post('projects/delete', 'ProjectController::delete'); // Hapus proyek

$routes->get('projects/(:num)/members', 'ProjectController::showProjectMembers/$1');

