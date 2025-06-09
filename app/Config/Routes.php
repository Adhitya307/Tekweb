<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==========================
// AUTHENTICATION ROUTES (bebas akses, tanpa auth filter)
// ==========================
$routes->get('/', 'Auth::login'); // Halaman login (default)
$routes->get('/register', 'Auth::register'); // Form registrasi
$routes->post('/register', 'Auth::process_register'); // Proses registrasi
$routes->get('/login', 'Auth::login'); // Form login
$routes->post('/login', 'Auth::process_login'); // Proses login
$routes->get('/logout', 'Auth::logout'); // Logout
$routes->get('/logout', 'Auth::logout');


// ==========================
// GOOGLE AUTH ROUTES (bebas akses)
// ==========================
$routes->get('/google-login', 'GoogleAuth::redirect'); // Redirect ke login Google
$routes->get('/google-callback', 'GoogleAuth::callback'); // Callback dari Google login

// ==========================
// PASSWORD MANAGEMENT ROUTES (bebas akses)
// ==========================
$routes->get('/atur-password', 'Auth::setPassword'); // Form atur password awal
$routes->post('/atur-password', 'Auth::savePassword'); // Simpan password

$routes->get('/forgot-password', 'Auth::forgotPasswordForm'); // Form lupa password
$routes->post('/forgot-password', 'Auth::sendResetToken'); // Kirim token reset
$routes->get('/reset-password', 'Auth::resetPasswordForm'); // Form reset password
$routes->post('/reset-password', 'Auth::updatePasswordFromToken'); // Update password dengan token


// ==========================
// PROTECTED ROUTES (harus login) => pakai filter 'auth'
// ==========================
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // DASHBOARD ROUTES
    $routes->get('/dash', 'Dash::index');
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->post('/projects/create', 'Dashboard::create');

    // PROJECT ROUTES
    $routes->get('project/(:num)', 'ProjectController::detail/$1'); // Tampilkan detail proyek (mungkin duplikat)
    $routes->get('project/(:num)/task/create', 'ProjectController::createTask/$1'); // Form tambah task
    $routes->post('project/(:num)/task/store', 'ProjectController::storeTask/$1'); // Simpan task baru
    $routes->get('project/(:num)', 'ProjectController::showProjectDetail/$1');
    $routes->get('projects/(:num)', 'ProjectController::showProjectDetail/$1');

    // TASK ROUTES
    $routes->get('task/(:num)', 'ProjectController::showTask/$1'); // Tampilkan detail task
    $routes->get('task/edit/(:num)', 'ProjectController::editTask/$1');
    $routes->post('task/update/(:num)', 'ProjectController::updateTask/$1');
    $routes->delete('task/(:num)', 'ProjectController::deleteTask/$1');
    $routes->delete('task/delete/(:num)', 'ProjectController::deleteTask/$1');

    // PROJECT ACTION ROUTES
    $routes->post('/projects/invite', 'ProjectController::inviteMember'); // Undang anggota ke proyek
    $routes->post('/kirim-undangan', 'Auth::kirimUndangan'); // Kirim undangan dari Auth
    $routes->post('projects/update', 'ProjectController::update'); // Update proyek
    $routes->post('projects/delete', 'ProjectController::delete'); // Hapus proyek

    $routes->get('projects/(:num)/members', 'ProjectController::showProjectMembers/$1');

    $routes->post('project/update', 'ProjectController::update');
    $routes->post('task/(:num)/update', 'ProjectController::updateTask/$1');

    $routes->post('comments/store', 'CommentController::store');

    $routes->post('project/update-status', 'ProjectController::updateStatus');
    $routes->get('task/(:num)/edit', 'ProjectController::editTask/$1');


    // PROFILE ROUTES
    $routes->get('/profile', 'ProfileController::index');
    $routes->post('/profile/update', 'ProfileController::update');
});

// Route About Us
$routes->get('/about', 'AboutController::index');

