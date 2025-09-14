<?php
declare(strict_types=1);

// Front Controller

// Composer autoload (optional if added later)
// require __DIR__ . '/../vendor/autoload.php';

// Harden session configuration before starting session
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
// SameSite strict to reduce CSRF risk on session
if (PHP_VERSION_ID >= 70300) {
    ini_set('session.cookie_samesite', 'Strict');
}
// Enable secure cookies when over HTTPS (also behind proxies)
$isHttps = (
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower((string)$_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
);
if ($isHttps) {
    ini_set('session.cookie_secure', '1');
}
session_start();

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/app/Core/Env.php';
require BASE_PATH . '/app/Core/Database.php';
require BASE_PATH . '/config/config.php';
require BASE_PATH . '/app/Core/Router.php';
require BASE_PATH . '/app/Core/Controller.php';
require BASE_PATH . '/app/Core/View.php';
require BASE_PATH . '/app/Core/Str.php';
require BASE_PATH . '/app/Validation/Validator.php';

// Controllers and Models
require BASE_PATH . '/app/Models/Lansia.php';
require BASE_PATH . '/app/Models/Pemeriksaan.php';
// Auth: User model & controller
require BASE_PATH . '/app/Models/User.php';
require BASE_PATH . '/app/Controllers/AuthController.php';

require BASE_PATH . '/app/Controllers/HomeController.php';
require BASE_PATH . '/app/Controllers/LansiaController.php';
require BASE_PATH . '/app/Controllers/PemeriksaanController.php';
require BASE_PATH . '/app/Controllers/FindController.php';
require BASE_PATH . '/app/Controllers/PetugasController.php';
require BASE_PATH . '/app/Controllers/ProfileController.php';

// Ensure timezone
date_default_timezone_set(env('TIMEZONE', 'Asia/Jakarta'));

// Ensure a CSRF token exists for forms
if (empty($_SESSION['csrf_token'])) {
    try {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    } catch (\Throwable $e) {
        $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
    }
}

use App\Core\Router;

$router = new Router();

// Public auth routes
$router->get('/login', [App\Controllers\AuthController::class, 'login']);
$router->post('/login', [App\Controllers\AuthController::class, 'attempt']);
$router->post('/logout', [App\Controllers\AuthController::class, 'logout']);

// Protected routes (authenticated users)
$router->get('/', [App\Controllers\HomeController::class, 'index']);
$router->get('/lansia', [App\Controllers\LansiaController::class, 'index']);
$router->get('/lansia/create', [App\Controllers\LansiaController::class, 'create']);
$router->post('/lansia', [App\Controllers\LansiaController::class, 'store']);
$router->get('/lansia/{kode}', [App\Controllers\LansiaController::class, 'show']);
$router->get('/lansia/{kode}/pemeriksaan', [App\Controllers\PemeriksaanController::class, 'form']);
$router->post('/lansia/{kode}/pemeriksaan', [App\Controllers\PemeriksaanController::class, 'store']);
$router->post('/lansia/{kode}/pemeriksaan/fisik', [App\Controllers\PemeriksaanController::class, 'storeFisik']);
$router->post('/lansia/{kode}/pemeriksaan/kesehatan', [App\Controllers\PemeriksaanController::class, 'storeKesehatan']);
$router->get('/find', [App\Controllers\FindController::class, 'index']);
$router->post('/find', [App\Controllers\FindController::class, 'submit']);

// Petugas management (admin only)
$router->post('/petugas/{id}/hapus', [App\Controllers\PetugasController::class, 'destroy']);
$router->get('/petugas', [App\Controllers\PetugasController::class, 'index']);
$router->get('/petugas/create', [App\Controllers\PetugasController::class, 'create']);
$router->post('/petugas', [App\Controllers\PetugasController::class, 'store']);

// Profile
$router->get('/profil', [App\Controllers\ProfileController::class, 'index']);
$router->get('/profil/edit', [App\Controllers\ProfileController::class, 'edit']);
$router->post('/profil/nama', [App\Controllers\ProfileController::class, 'updateName']);
$router->post('/profil/password', [App\Controllers\ProfileController::class, 'updatePassword']);

// Simple admin-only gate before dispatch
$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
$path = rtrim(strtok($_SERVER['REQUEST_URI'] ?? '/', '?'), '/') ?: '/';
$isAuthRoute = ($path === '/login' && in_array($method, ['GET','POST'], true)) || ($path === '/logout' && $method === 'POST');

if (!$isAuthRoute) {
    if (!isset($_SESSION['user'])) {
        // Remember intended URL to redirect after login
        $next = rawurlencode($path);
        header('Location: /login?next=' . $next);
        exit;
    }
}

// Dispatch
$router->dispatch($method, $path);
