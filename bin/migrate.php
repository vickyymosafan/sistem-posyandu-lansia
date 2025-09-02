<?php
declare(strict_types=1);

// Simple migration + admin seeder for Sistem Posyandu Lansia

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/app/Core/Env.php';
require BASE_PATH . '/app/Core/Database.php';
require BASE_PATH . '/config/config.php';

use App\Core\Database;
use PDO; use PDOException; use Throwable; use RuntimeException;

function println(string $msg = ''): void { fwrite(STDOUT, $msg . PHP_EOL); }
function printErr(string $msg): void { fwrite(STDERR, $msg . PHP_EOL); }

function parseArgs(array $argv): array
{
    $args = ['admin' => null, 'password' => null, 'skip-sql' => false];
    foreach (array_slice($argv, 1) as $a) {
        if ($a === '--skip-sql') { $args['skip-sql'] = true; continue; }
        if (str_starts_with($a, '--admin=')) { $args['admin'] = substr($a, 8); continue; }
        if (str_starts_with($a, '--password=')) { $args['password'] = substr($a, 11); continue; }
    }
    // Fallback to .env
    $args['admin'] = $args['admin'] ?? env('ADMIN_NAME', 'admin');
    $args['password'] = $args['password'] ?? env('ADMIN_PASS', '');
    return $args;
}

function generatePassword(int $length = 14): string
{
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@$%^&*_-+';
    $max = strlen($chars) - 1;
    $pw = '';
    for ($i = 0; $i < $length; $i++) {
        $pw .= $chars[random_int(0, $max)];
    }
    return $pw;
}

function sqlStatements(string $sql): array
{
    // Normalize line endings
    $sql = str_replace("\r\n", "\n", $sql);
    $len = strlen($sql);
    $stmts = [];
    $buf = '';
    $inSingle = false; $inDouble = false; $inLine = false; $inBlock = false;
    for ($i = 0; $i < $len; $i++) {
        $ch = $sql[$i];
        $next = $sql[$i + 1] ?? '';
    if ($inLine) {
            if ($ch === "\n") { $inLine = false; /* drop comment newline */ }
            continue;
        }
        if ($inBlock) {
            // Close block comment and drop its content entirely
            if ($ch === '*' && $next === '/') { $inBlock = false; $i++; }
            continue;
        }
        // Start comments
        if (!$inSingle && !$inDouble) {
            if ($ch === '-' && $next === '-') { $inLine = true; $i++; continue; }
            if ($ch === '/' && $next === '*') { $inBlock = true; $i++; continue; }
        }
        // Quotes (handle SQL '' escaping inside single quotes)
        if (!$inDouble && $ch === "'" ) {
            if ($inSingle) {
                $peek = $sql[$i + 1] ?? '';
                if ($peek === "'") { $buf .= "''"; $i++; continue; }
                $inSingle = false; $buf .= $ch; continue;
            } else {
                $inSingle = true; $buf .= $ch; continue;
            }
        }
        if (!$inSingle && $ch === '"') { $inDouble = !$inDouble; $buf .= $ch; continue; }

        if ($ch === ';' && !$inSingle && !$inDouble) {
            $trim = trim($buf);
            if ($trim !== '') { $stmts[] = $trim; }
            $buf = '';
            continue;
        }
        $buf .= $ch;
    }
    $trim = trim($buf);
    if ($trim !== '') { $stmts[] = $trim; }
    return $stmts;
}

function isIgnorableMigrationError(Throwable $e, string $stmt): bool
{
    $msg = strtolower($e->getMessage());
    $code = null; $state = null;
    if ($e instanceof PDOException) {
        $info = $e->errorInfo ?? null;
        if (is_array($info)) { $state = $info[0] ?? null; $code = $info[1] ?? null; }
    }
    $isCreate = str_starts_with(strtoupper(ltrim($stmt)), 'CREATE TABLE');
    $isAlter = str_starts_with(strtoupper(ltrim($stmt)), 'ALTER TABLE');

    // Table exists
    if ($isCreate && ($state === '42S01' || $code === 1050 || str_contains($msg, 'already exists'))) return true;
    // Duplicate key/column/constraint on ALTER
    if ($isAlter) {
        if (in_array($code, [1060,1061,1068,1091,1826,1832,3780,3815,1022], true)) return true;
        if (str_contains($msg, 'duplicate') || str_contains($msg, 'already exists') || str_contains($msg, 'multiple primary key')) return true;
    }
    return false;
}

function runSqlFile(PDO $pdo, string $path): void
{
    if (!is_file($path)) {
        throw new RuntimeException('SQL file not found: ' . $path);
    }
    $sql = file_get_contents($path);
    if ($sql === false) { throw new RuntimeException('Failed to read SQL file'); }
    $stmts = sqlStatements($sql);
    println('Executing SQL migration: ' . basename($path));
    foreach ($stmts as $idx => $stmt) {
        $s = trim($stmt);
        if ($s === '' || strtoupper(substr($s, 0, 4)) === 'SET ' ) { // allow SET statements
            try { $pdo->exec($s); } catch (Throwable $e) { /* ignore non-critical SET errors */ }
            continue;
        }
        try {
            $pdo->exec($s);
        } catch (Throwable $e) {
            if (isIgnorableMigrationError($e, $s)) {
                println('Skipping (exists): #' . ($idx + 1));
                continue;
            }
            printErr("Error executing statement #" . ($idx + 1) . ": " . $e->getMessage());
            printErr($s);
            throw $e;
        }
    }
    println('SQL migration completed.');
}

function ensureAdmin(PDO $pdo, string $name, string $password): ?string
{
    // Check if exists
    $st = $pdo->prepare('SELECT id FROM users WHERE nama = :n AND role = \'admin\' LIMIT 1');
    $st->execute([':n' => $name]);
    $id = (int)($st->fetchColumn() ?: 0);
    if ($id > 0) { return null; }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $ins = $pdo->prepare('INSERT INTO users (nama, role, password_hash, aktif, created_at, updated_at) VALUES (:n, \'admin\', :h, 1, NOW(), NOW())');
    $ins->execute([':n' => $name, ':h' => $hash]);
    return $password;
}

function ensureColumn(PDO $pdo, string $table, string $column, string $definition): void
{
    $q = $pdo->prepare('SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = :c');
    $q->execute([':t' => $table, ':c' => $column]);
    $exists = (int)$q->fetchColumn() > 0;
    if (!$exists) {
        $sql = "ALTER TABLE `$table` ADD COLUMN $definition";
        println("Adding column $table.$column ...");
        $pdo->exec($sql);
    }
}

function ensureUniqueIndex(PDO $pdo, string $table, string $indexName, string $columns): void
{
    $q = $pdo->prepare('SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND INDEX_NAME = :i');
    $q->execute([':t' => $table, ':i' => $indexName]);
    $exists = (int)$q->fetchColumn() > 0;
    if (!$exists) {
        $sql = "ALTER TABLE `$table` ADD UNIQUE KEY `$indexName` ($columns)";
        println("Adding unique index $table.$indexName ...");
        $pdo->exec($sql);
    }
}

// Main
try {
    $pdo = Database::pdo();
} catch (Throwable $e) {
    printErr('Gagal koneksi database: ' . $e->getMessage());
    exit(1);
}

$args = parseArgs($argv);

try {
    if (!$args['skip-sql']) {
        runSqlFile($pdo, BASE_PATH . '/database/posyandu.sql');
    } else {
        println('Skipping SQL file execution as requested.');
    }

    // Ensure new columns exist for lansia (NIK, KK)
    try {
        ensureColumn($pdo, 'lansia', 'nik', "varchar(16) NULL AFTER `nama_lengkap`");
    } catch (Throwable $e) { if (!isIgnorableMigrationError($e, 'ALTER TABLE lansia ADD nik')) { throw $e; } }
    try {
        ensureColumn($pdo, 'lansia', 'kk', "varchar(16) NULL AFTER `nik`");
    } catch (Throwable $e) { if (!isIgnorableMigrationError($e, 'ALTER TABLE lansia ADD kk')) { throw $e; } }
    try {
        ensureUniqueIndex($pdo, 'lansia', 'uniq_lansia_nik', '`nik`');
    } catch (Throwable $e) { if (!isIgnorableMigrationError($e, 'ALTER TABLE lansia ADD UNIQUE uniq_lansia_nik')) { throw $e; } }

    $admin = $args['admin'] ?: 'admin';
    $pass = $args['password'];
    if ($pass === '' || $pass === null) {
        $pass = generatePassword();
        println('No ADMIN_PASS provided. Generated a secure password.');
    }

    $maybeNew = ensureAdmin($pdo, $admin, $pass);
    if ($maybeNew === null) {
        println('Admin user already exists: ' . $admin);
    } else {
        println('Admin user created: ' . $admin);
        println('Admin password: ' . $maybeNew);
    }

    println('Migration and seeding completed successfully.');
    exit(0);
} catch (Throwable $e) {
    printErr('Migration failed: ' . $e->getMessage());
    exit(1);
}
