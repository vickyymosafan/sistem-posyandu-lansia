<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(): void
    {
        if (!isset($_SESSION['user']['id'])) {
            $this->redirect('/login');
            return;
        }
        $id = (int)$_SESSION['user']['id'];
        $me = User::findById($id);
        if (!$me) { $me = $_SESSION['user']; }
        $this->view('profile/index', [
            'title' => 'Profil Saya',
            'me' => $me,
        ]);
    }

    public function edit(): void
    {
        if (!isset($_SESSION['user']['id'])) { $this->redirect('/login'); return; }
        $id = (int)$_SESSION['user']['id'];
        $me = User::findById($id);
        if (!$me) { $me = $_SESSION['user']; }
        $this->view('profile/edit', [
            'title' => 'Ubah Profil',
            'me' => $me,
            'errors' => $_SESSION['errors'] ?? [],
            'success' => $_SESSION['success'] ?? null,
            'old' => $_SESSION['old'] ?? [],
        ]);
        unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);
    }

    public function updateName(): void
    {
        if (!isset($_SESSION['user']['id'])) { $this->redirect('/login'); return; }
        $id = (int)$_SESSION['user']['id'];
        $nama = trim((string)($_POST['nama'] ?? ''));
        $csrf = (string)($_POST['csrf'] ?? '');
        if ($csrf === '' || !hash_equals($_SESSION['csrf_token'] ?? '', $csrf)) {
            $_SESSION['errors'] = ['csrf' => 'Sesi tidak valid. Muat ulang halaman.'];
            $_SESSION['old'] = ['nama' => $nama];
            $this->redirect('/profil/edit');
            return;
        }
        $v = new \App\Validation\Validator(['nama' => $nama]);
        $v->required('nama', 'Nama')->maxLen('nama', 150, 'Nama');
        if (!($v->passes())) {
            $_SESSION['errors'] = $v->errors();
            $_SESSION['old'] = ['nama' => $nama];
            $this->redirect('/profil/edit');
            return;
        }
        if (\App\Models\User::existsByNamaExceptId($nama, $id)) {
            $_SESSION['errors'] = ['nama' => 'Nama sudah digunakan pengguna lain'];
            $_SESSION['old'] = ['nama' => $nama];
            $this->redirect('/profil/edit');
            return;
        }
        try {
            \App\Models\User::updateNama($id, $nama);
            $_SESSION['user']['nama'] = $nama;
            $_SESSION['success'] = 'Nama berhasil diperbarui.';
            $this->redirect('/profil/edit');
        } catch (\Throwable $e) {
            http_response_code(500);
            echo 'Gagal memperbarui nama: ' . htmlspecialchars($e->getMessage());
        }
    }

    public function updatePassword(): void
    {
        if (!isset($_SESSION['user']['id'])) { $this->redirect('/login'); return; }
        $id = (int)$_SESSION['user']['id'];
        $current = (string)($_POST['current_password'] ?? '');
        $new = (string)($_POST['new_password'] ?? '');
        $confirm = (string)($_POST['confirm_password'] ?? '');
        $csrf = (string)($_POST['csrf'] ?? '');

        if ($csrf === '' || !hash_equals($_SESSION['csrf_token'] ?? '', $csrf)) {
            $_SESSION['errors'] = ['csrf' => 'Sesi tidak valid. Muat ulang halaman.'];
            $this->redirect('/profil/edit');
            return;
        }

        // Validate new password
        $v = new \App\Validation\Validator(['new' => $new, 'confirm' => $confirm, 'current' => $current]);
        $v->required('current', 'Kata sandi saat ini');
        $v->required('new', 'Kata sandi baru')->regex('new', '/^.{8,}$/', 'Kata sandi baru minimal 8 karakter');
        $v->required('confirm', 'Konfirmasi kata sandi');
        if ($new !== $confirm) {
            $errs = $v->errors();
            $errs['confirm'] = 'Konfirmasi tidak cocok';
            $_SESSION['errors'] = $errs;
            $this->redirect('/profil/edit');
            return;
        }

        // Verify current password
        $user = \App\Models\User::findActiveByNama((string)($_SESSION['user']['nama'] ?? ''));
        if (!$user || !password_verify($current, (string)($user['password_hash'] ?? ''))) {
            $_SESSION['errors'] = ['current' => 'Kata sandi saat ini salah'];
            $this->redirect('/profil/edit');
            return;
        }

        try {
            \App\Models\User::updatePassword($id, $new);
            session_regenerate_id(true);
            // Rotate CSRF
            try { $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); } catch (\Throwable) {}
            $_SESSION['success'] = 'Kata sandi berhasil diperbarui.';
            $this->redirect('/profil/edit');
        } catch (\Throwable $e) {
            http_response_code(500);
            echo 'Gagal memperbarui kata sandi: ' . htmlspecialchars($e->getMessage());
        }
    }
}
