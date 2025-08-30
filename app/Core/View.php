<?php
namespace App\Core;

class View
{
    public static function render(string $template, array $data = []): void
    {
        $path = dirname(__DIR__) . '/Views/' . str_replace('.', '/', $template) . '.php';
        if (!is_file($path)) {
            http_response_code(500);
            echo 'View not found: ' . htmlspecialchars($template);
            return;
        }
        extract($data, EXTR_SKIP);
        $view_template_path = $path;
        include dirname(__DIR__) . '/Views/layouts/main.php';
    }
}
