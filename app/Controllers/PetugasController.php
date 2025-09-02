<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Validation\Validator;
use App\Models\User;

class PetugasController extends Controller
{
    public function create(): void
    {
        // Admin-only
        $this->requireAdmin();

        $this->view('petugas/create', [
            'title' => 'Tambah Petugas',
            'errors' => $_SESSION['errors'] ?? [],
            'old' => $_SESSION['old'] ?? [],
            'success' => $_SESSION['success'] ?? null,
        ]);
        unset($_SESSION['errors'], $_SESSION['old'], $_SESSION['success']);
    }

    public function store(): void
    {
        $this->requireAdmin();

        $input = [
            'nama' => trim((string)($_POST['nama'] ?? '')),
            'password' => (string)($_POST['password'] ?? ''),
            'aktif' => isset($_POST['aktif']) ? 1 : 0,
            'csrf' => (string)($_POST['csrf'] ?? ''),
        ];

        if ($input['csrf'] === '' || !hash_equals($_SESSION['csrf_token'] ?? '', $input['csrf'])) {
            $_SESSION['errors'] = ['csrf' => 'Sesi tidak valid. Muat ulang halaman.'];
            $_SESSION['old'] = $input;
            $this->redirect('/petugas/create');
            return;
        }

        $v = new Validator($input);
        $v->required('nama', 'Nama petugas')->maxLen('nama', 150, 'Nama petugas');
        $v->required('password', 'Kata sandi')->regex('password', '/^.{8,}$/', 'Kata sandi minimal 8 karakter');

        if (User::existsByNamaRole($input['nama'], 'petugas')) {
            $_SESSION['errors'] = array_merge($v->errors(), [ 'nama' => 'Nama petugas sudah digunakan' ]);
            $_SESSION['old'] = $input;
            $this->redirect('/petugas/create');
            return;
        }

        if (!$v->passes()) {
            $_SESSION['errors'] = $v->errors();
            $_SESSION['old'] = $input;
            $this->redirect('/petugas/create');
            return;
        }

        try {
            $id = User::createPetugas($input['nama'], $input['password'], (int)$input['aktif']);
            $_SESSION['success'] = 'Petugas berhasil ditambahkan.';
            $this->redirect('/petugas/create');
        } catch (\Throwable $e) {
            http_response_code(500);
            echo 'Gagal menambahkan petugas: ' . htmlspecialchars($e->getMessage());
        }
    }
}

