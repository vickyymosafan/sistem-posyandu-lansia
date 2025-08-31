<?php
declare(strict_types=1);

// Front Controller

// Composer autoload (optional if added later)
// require __DIR__ . '/../vendor/autoload.php';

// Bootstrapping
ini_set('session.use_strict_mode', '1');
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
require BASE_PATH . '/app/Controllers/HomeController.php';
require BASE_PATH . '/app/Controllers/LansiaController.php';
require BASE_PATH . '/app/Controllers/PemeriksaanController.php';
require BASE_PATH . '/app/Controllers/FindController.php';

date_default_timezone_set(env('TIMEZONE', 'Asia/Jakarta'));

use App\Core\Router;

$router = new Router();

// Routes
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

// Dispatch
$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', strtok($_SERVER['REQUEST_URI'] ?? '/', '?'));
