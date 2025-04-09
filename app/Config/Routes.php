<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/', 'Auth::login');

$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::process_register');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::process_login');
$routes->get('/logout', 'Auth::logout');

$routes->get('/dashboard', 'Dashboard::index');

$routes->get('/google-login', 'GoogleAuth::redirect');
$routes->get('/google-callback', 'GoogleAuth::callback');

$routes->get('/atur-password', 'Auth::setPassword');
$routes->post('/atur-password', 'Auth::savePassword');

$routes->get('/forgot-password', 'Auth::forgotPasswordForm');
$routes->post('/forgot-password', 'Auth::sendResetToken');
$routes->get('/reset-password', 'Auth::resetPasswordForm');
$routes->post('/reset-password', 'Auth::updatePasswordFromToken');


