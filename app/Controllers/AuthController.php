<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function login(): void
    {
        if (($user = ($_SESSION['user'] ?? null)) && (($user['role'] ?? '') === 'admin')) {
            $this->redirect('/');
            return;
        }
        $this->view('auth/login', [
            'title' => 'Login Admin - Posyandu Lansia',
            'isAuthPage' => true,
            'error' => $_SESSION['login_error'] ?? null,
            'next' => isset($_GET['next']) ? (string)$_GET['next'] : '/',
            'old' => $_SESSION['login_old'] ?? [],
            'csrf' => $_SESSION['csrf_token'] ?? '',
        ]);
        unset($_SESSION['login_error'], $_SESSION['login_old']);
    }

    public function attempt(): void
    {
        // Throttle by IP
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $throttleKey = 'login_throttle_' . $ip;
        $throttle = $_SESSION[$throttleKey] ?? ['count' => 0, 'locked_until' => 0];
        $now = time();
        if (($throttle['locked_until'] ?? 0) > $now) {
            $_SESSION['login_error'] = 'Terlalu banyak percobaan. Coba lagi beberapa menit.';
            $this->redirect('/login');
            return;
        }

        $nama = trim((string)($_POST['nama'] ?? ''));
        $password = (string)($_POST['password'] ?? '');
        $csrf = (string)($_POST['csrf'] ?? '');
        $next = (string)($_POST['next'] ?? '/');
        $next = $next !== '' ? $next : '/';
        // prevent open redirect
        if (!str_starts_with($next, '/')) { $next = '/'; }

        $_SESSION['login_old'] = ['nama' => $nama];

        if ($csrf === '' || !hash_equals($_SESSION['csrf_token'] ?? '', $csrf)) {
            $_SESSION['login_error'] = 'Sesi tidak valid. Muat ulang halaman dan coba lagi.';
            $this->redirect('/login?next=' . rawurlencode($next));
            return;
        }

        if ($nama === '' || $password === '') {
            $_SESSION['login_error'] = 'Nama dan kata sandi wajib diisi';
            $this->redirect('/login?next=' . rawurlencode($next));
            return;
        }

        // Allow both admin and petugas to login (must be aktif=1)
        $user = User::findActiveByNama($nama);
        $ok = false;
        if ($user && isset($user['password_hash'])) {
            $ok = password_verify($password, (string)$user['password_hash']);
        }

        if (!$ok) {
            // update throttle
            $throttle['count'] = (int)($throttle['count'] ?? 0) + 1;
            if ($throttle['count'] >= 5) {
                $throttle['locked_until'] = $now + 10 * 60; // 10 minutes
                $throttle['count'] = 0; // reset after lock
            }
            $_SESSION[$throttleKey] = $throttle;

            // unify error message
            $_SESSION['login_error'] = 'Nama atau kata sandi salah.';
            $this->redirect('/login?next=' . rawurlencode($next));
            return;
        }

        // success - reset throttle
        $_SESSION[$throttleKey] = ['count' => 0, 'locked_until' => 0];

        // prevent session fixation
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => (int)$user['id'],
            'nama' => (string)$user['nama'],
            'role' => (string)$user['role'],
            'login_time' => date('c'),
            'ip' => $ip,
            'ua' => substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255),
        ];

        // rotate CSRF token after login
        try { $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); } catch (\Throwable) {}

        $this->redirect($next);
    }

    public function logout(): void
    {
        $csrf = (string)($_POST['csrf'] ?? '');
        if ($csrf === '' || !hash_equals($_SESSION['csrf_token'] ?? '', $csrf)) {
            http_response_code(400);
            echo 'Permintaan tidak valid';
            return;
        }

        // Clear and destroy session safely
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], ($params['secure'] ?? false), true);
        }
        session_destroy();

        // Start fresh to hold new CSRF for login form
        session_start();
        try { $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); } catch (\Throwable) {}

        $this->redirect('/login');
    }
}
