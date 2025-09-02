<?php
declare(strict_types=1);

// Recreate only `lansia` table from database/posyandu.sql

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/app/Core/Env.php';
require BASE_PATH . '/app/Core/Database.php';
require BASE_PATH . '/config/config.php';

use App\Core\Database;

function println(string $s = ''): void { fwrite(STDOUT, $s . PHP_EOL); }
function printErr(string $s): void { fwrite(STDERR, $s . PHP_EOL); }

function sqlStatements(string $sql): array
{
    $sql = str_replace("\r\n", "\n", $sql);
    $len = strlen($sql);
    $stmts = []; $buf = '';
    $inSingle = false; $inDouble = false; $inLine = false; $inBlock = false;
    for ($i = 0; $i < $len; $i++) {
        $ch = $sql[$i]; $next = $sql[$i + 1] ?? '';
        if ($inLine) { if ($ch === "\n") { $inLine = false; } continue; }
        if ($inBlock) { if ($ch === '*' && $next === '/') { $inBlock = false; $i++; } continue; }
        if (!$inSingle && !$inDouble) {
            if ($ch === '-' && $next === '-') { $inLine = true; $i++; continue; }
            if ($ch === '/' && $next === '*') { $inBlock = true; $i++; continue; }
        }
        if (!$inDouble && $ch === "'") { $inSingle = !$inSingle; $buf .= $ch; continue; }
        if (!$inSingle && $ch === '"') { $inDouble = !$inDouble; $buf .= $ch; continue; }
        if ($ch === ';' && !$inSingle && !$inDouble) { $trim = trim($buf); if ($trim !== '') $stmts[] = $trim; $buf=''; continue; }
        $buf .= $ch;
    }
    $trim = trim($buf); if ($trim !== '') $stmts[] = $trim;
    return $stmts;
}

try {
    $pdo = Database::pdo();
} catch (\Throwable $e) {
    printErr('DB connection failed: ' . $e->getMessage());
    exit(1);
}

// Drop table lansia safely
println('Dropping table `lansia` (if exists)...');
try {
    $pdo->exec('SET FOREIGN_KEY_CHECKS=0');
    $pdo->exec('DROP TABLE IF EXISTS `lansia`');
    $pdo->exec('SET FOREIGN_KEY_CHECKS=1');
} catch (\Throwable $e) {
    printErr('Failed dropping table: ' . $e->getMessage());
    exit(1);
}

// Load SQL file and extract statements for `lansia`
$path = BASE_PATH . '/database/posyandu.sql';
if (!is_file($path)) {
    printErr('SQL file not found: ' . $path);
    exit(1);
}

$sql = file_get_contents($path);
$stmts = sqlStatements($sql);

$pick = [];
foreach ($stmts as $s) {
    $u = strtoupper(preg_replace('/\s+/', ' ', $s));
    if (preg_match('/^CREATE\s+TABLE\s+`?LANSIA`?/i', $s)) { $pick[] = $s; continue; }
    if (preg_match('/^ALTER\s+TABLE\s+`?LANSIA`?/i', $s)) { $pick[] = $s; continue; }
    // Keep AUTO_INCREMENT modification if it targets lansia
    if (preg_match('/^ALTER\s+TABLE\s+`?LANSIA`?\s+MODIFY/i', $s)) { $pick[] = $s; continue; }
}

if (!$pick) {
    printErr('No statements for table `lansia` found in SQL file.');
    exit(1);
}

// Inject keys from subsequent ALTERs into CREATE TABLE so that referenced FKs are satisfied
// Collect keys from ALTER lines
$keys = [];
for ($i = 1; $i < count($pick); $i++) {
    if (preg_match('/ADD\s+PRIMARY\s+KEY\s*\(([^\)]*)\)/i', $pick[$i], $m)) {
        $keys[] = 'PRIMARY KEY (' . $m[1] . ')';
    }
    if (preg_match('/ADD\s+UNIQUE\s+KEY\s+`?([^`\s]+)`?\s*\(([^\)]*)\)/i', $pick[$i], $m)) {
        $keys[] = 'UNIQUE KEY `' . $m[1] . '` (' . $m[2] . ')';
    }
}
if ($keys && !preg_match('/PRIMARY\s+KEY/i', $pick[0])) {
    if (preg_match('/\)\s*ENGINE/i', $pick[0], $mm, PREG_OFFSET_CAPTURE)) {
        $pos = $mm[0][1];
        $before = substr($pick[0], 0, $pos);
        $after = substr($pick[0], $pos);
        $before = rtrim($before);
        if (substr($before, -1) !== ',') { $before .= ","; }
        $pick[0] = $before . "\n  " . implode(",\n  ", $keys) . "\n" . $after;
    }
}

// Drop ALTERs that only (re-)add keys we've injected
if ($keys) {
    $filtered = [];
    foreach ($pick as $idx => $stmt) {
        if ($idx === 0) { $filtered[] = $stmt; continue; }
        if (preg_match('/^ALTER\s+TABLE\s+`?lansia`?/i', $stmt)) {
            if (preg_match('/ADD\s+PRIMARY\s+KEY/i', $stmt)) { continue; }
            if (preg_match('/ADD\s+UNIQUE\s+KEY/i', $stmt)) { continue; }
        }
        $filtered[] = $stmt;
    }
    $pick = $filtered;
}

println('Recreating table `lansia`...');
try {
    $pdo->exec('SET FOREIGN_KEY_CHECKS=0');
    foreach ($pick as $i => $s) {
        try {
            $pdo->exec($s);
            println('OK: statement #' . ($i + 1));
        } catch (\Throwable $e) {
            printErr('Error on statement #' . ($i + 1) . ': ' . $e->getMessage());
            printErr($s);
            throw $e;
        }
    }
    $pdo->exec('SET FOREIGN_KEY_CHECKS=1');
    println('Done. Table `lansia` recreated successfully.');
} catch (\Throwable $e) {
    $pdo->exec('SET FOREIGN_KEY_CHECKS=1');
    exit(1);
}
exit(0);
