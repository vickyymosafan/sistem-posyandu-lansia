<?php
use App\Core\Database;

// Database singleton init
Database::init([
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => (int)env('DB_PORT', 3306),
    'name' => env('DB_NAME', 'posyandu'),
    'user' => env('DB_USER', 'root'),
    'pass' => env('DB_PASS', 'root'),
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
]);

// App constants
define('APP_URL', rtrim(env('APP_URL', 'http://localhost:8000'), '/'));
