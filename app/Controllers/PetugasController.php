<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Validation\Validator;
use App\Models\User;

class PetugasController extends Controller
{
    public function index(): void
    {
        // Admin-only
        $this->requireAdmin();

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $q = isset($_GET['q']) ? trim((string)$_GET['q']) : null;
        $per = isset($_GET['per']) ? (int)$_GET['per'] : 20;
        $data = User::paginatePetugas($page, $per, $q);

        $this->view('petugas/index', [
            'title' => 'Data Petugas',
            'items' => $data['items'],
            'total' => $data['total'],
            'page' => $data['page'],
            'pages' => $data['pages'],
            'perPage' => $data['perPage'],
            'q' => $q,
            'success' => $_SESSION['success'] ?? null,
            'error' => $_SESSION['error'] ?? null,
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }

    public function destroy(string $id): void
    {
        $this->requireAdmin();

        $csrf = (string)($_POST['csrf'] ?? '');
        if ($csrf === '' || !hash_equals($_SESSION['csrf_token'] ?? '', $csrf)) {
            $_SESSION['error'] = 'Sesi tidak valid. Muat ulang halaman.';
            $this->redirect('/petugas');
            return;
        }

        $uid = (int)$id;
        if ($uid <= 0) {
            $_SESSION['error'] = 'ID tidak valid.';
            $this->redirect('/petugas');
            return;
        }

        try {
            $ok = User::deletePetugas($uid);
            if ($ok) {
                $_SESSION['success'] = 'Petugas berhasil dihapus.';
            } else {
                $_SESSION['error'] = 'Petugas tidak ditemukan atau bukan role petugas.';
            }
            $this->redirect('/petugas');
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'Gagal menghapus petugas: ' . $e->getMessage();
            $this->redirect('/petugas');
        }
    }
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
