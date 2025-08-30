<?php
namespace App\Core {
    function env(string $key, $default = null) {
        static $vars = null;
        if ($vars === null) {
            $vars = [];
            $path = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . '.env';
            if (is_file($path)) {
                $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '' || $line[0] === '#') continue;
                    $parts = explode('=', $line, 2);
                    if (count($parts) === 2) {
                        $vars[trim($parts[0])] = trim($parts[1]);
                    }
                }
            }
        }
        return $vars[$key] ?? $default;
    }
}

// Define a global alias in the root namespace
namespace {
    if (!function_exists('env')) {
        function env(string $key, $default = null) { return \App\Core\env($key, $default); }
    }
}
