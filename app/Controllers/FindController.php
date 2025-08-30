<?php
namespace App\Controllers;

use App\Core\Controller;

class FindController extends Controller
{
    public function index(): void
    {
        $this->view('find/index', [
            'title' => 'Cari ID Unik',
            'error' => $_SESSION['find_error'] ?? null,
            'old' => $_SESSION['find_old'] ?? [],
        ]);
        unset($_SESSION['find_error'], $_SESSION['find_old']);
    }

    public function submit(): void
    {
        $kode = trim($_POST['kode'] ?? '');
        if ($kode === '') {
            $_SESSION['find_error'] = 'ID Unik wajib diisi';
            $_SESSION['find_old'] = ['kode' => ''];
            $this->redirect('/find');
            return;
        }
        $this->redirect('/lansia/' . rawurlencode($kode));
    }
}

