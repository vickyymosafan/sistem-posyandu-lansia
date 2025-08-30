<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;
    private static ?array $config = null;

    public static function init(array $config): void
    {
        // Store config; connect lazily on first ->pdo() call
        self::$config = $config;
    }

    public static function pdo(): PDO
    {
        if (!self::$pdo) {
            if (!self::$config) {
                throw new \RuntimeException('Database config not set');
            }
            $cfg = self::$config;
            $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
                $cfg['host'], $cfg['port'], $cfg['name']
            );
            try {
                self::$pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], $cfg['options'] ?? []);
            } catch (PDOException $e) {
                http_response_code(500);
                echo 'DB Connection failed: ' . htmlspecialchars($e->getMessage());
                exit;
            }
        }
        return self::$pdo;
    }
}
