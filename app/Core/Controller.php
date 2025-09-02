<?php
namespace App\Core;

class Controller
{
    protected function view(string $template, array $data = []): void
    {
        View::render($template, $data);
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    protected function json($data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    protected function requireAdmin(): void
    {
        $role = $_SESSION['user']['role'] ?? null;
        if ($role !== 'admin') {
            $curr = rtrim(strtok($_SERVER['REQUEST_URI'] ?? '/', '?'), '/') ?: '/';
            $this->redirect('/login?next=' . rawurlencode($curr));
        }
    }
}

