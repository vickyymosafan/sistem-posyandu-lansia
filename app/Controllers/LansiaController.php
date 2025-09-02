<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Str;
use App\Models\Lansia;
use App\Validation\Validator;

class LansiaController extends Controller
{
    public function index(): void
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $q = isset($_GET['q']) ? trim((string)$_GET['q']) : null;
        $per = isset($_GET['per']) ? (int)$_GET['per'] : 20;
        $data = \App\Models\Lansia::paginate($page, $per, $q);
        $this->view('lansia/index', [
            'title' => 'Daftar Lansia',
            'items' => $data['items'],
            'total' => $data['total'],
            'page' => $data['page'],
            'pages' => $data['pages'],
            'perPage' => $data['perPage'],
            'q' => $q,
        ]);
    }
    public function create(): void
    {
        $this->view('lansia/create', [
            'title' => 'Pendaftaran Lansia',
            'errors' => $_SESSION['errors'] ?? [],
            'old' => $_SESSION['old'] ?? [],
        ]);
        unset($_SESSION['errors'], $_SESSION['old']);
    }

    public function store(): void
    {
        $input = [
            'nama_lengkap' => trim($_POST['nama_lengkap'] ?? ''),
            'nik' => trim($_POST['nik'] ?? ''),
            'kk' => trim($_POST['kk'] ?? ''),
            'tgl_lahir' => trim($_POST['tgl_lahir'] ?? ''),
            'jk' => trim($_POST['jk'] ?? ''),
            'alamat' => trim($_POST['alamat'] ?? ''),
            'no_telp' => trim($_POST['no_telp'] ?? ''),
        ];

        $v = new Validator($input);
        $v->required('nama_lengkap', 'Nama lengkap')->maxLen('nama_lengkap', 150, 'Nama lengkap');
        $v->required('tgl_lahir', 'Tanggal lahir')->date('tgl_lahir', 'Tanggal lahir');
        // NIK & KK 16 digit
        $v->required('nik', 'NIK')->regex('nik', '/^\d{16}$/', 'NIK harus 16 digit angka');
        $v->required('kk', 'KK')->regex('kk', '/^\d{16}$/', 'KK harus 16 digit angka');
        $v->required('jk', 'Jenis kelamin')->enum('jk', ['L','P'], 'Jenis kelamin');
        $v->required('alamat', 'Alamat')->maxLen('alamat', 255, 'Alamat');
        $v->required('no_telp', 'Nomor telepon')->regex('no_telp', '/^(?:\+62|62|0)8[1-9][0-9]{7,10}$/', 'Nomor telepon tidak valid');

        if (!$v->passes()) {
            $_SESSION['errors'] = $v->errors();
            $_SESSION['old'] = $input;
            $this->redirect('/lansia/create');
            return;
        }

        // Cek duplikasi
        if (\App\Models\Lansia::existsByNama($input['nama_lengkap'])) {
            $_SESSION['errors'] = array_merge($v->errors(), [
                'nama_lengkap' => 'Nama lengkap sudah terdaftar. Gunakan nama yang berbeda.'
            ]);
            $_SESSION['old'] = $input;
            $this->redirect('/lansia/create');
            return;
        }
        if (\App\Models\Lansia::existsByNik($input['nik'])) {
            $_SESSION['errors'] = array_merge($v->errors(), [
                'nik' => 'NIK sudah terdaftar.'
            ]);
            $_SESSION['old'] = $input;
            $this->redirect('/lansia/create');
            return;
        }

        $pdo = Database::pdo();
        $pdo->beginTransaction();
        try {
            // generate unique kode with format: 'pasien' + YYYYMMDD + 2 base62 chars (length 16)
            do {
                $kode = Str::patientId();
            } while (Lansia::findByKode($kode));

            $input['id_unik'] = $kode;
            $id = Lansia::create($input);
            $pdo->commit();

            // Redirect to profil menggunakan ID unik
            $this->redirect('/lansia/' . $kode);
            return;
        } catch (\Throwable $e) {
            $pdo->rollBack();
            http_response_code(500);
            echo 'Gagal menyimpan data: ' . htmlspecialchars($e->getMessage());
        }
    }

    public function show(string $kode): void
    {
        $l = Lansia::findByKode($kode);
        if (!$l) { http_response_code(404); echo 'Data lansia tidak ditemukan'; return; }
        // Ambil 10 riwayat pemeriksaan terbaru
        $riwayat = \App\Models\Pemeriksaan::listByLansia((int)$l['id'], 10);
        $this->view('lansia/show', [
            'title' => 'Profil Lansia',
            'l' => $l,
            'riwayat' => $riwayat,
        ]);
    }

    // Endpoint riwayat dihapus (tidak terpakai)

    // QR/Barcode removed: system now uses Unique ID only
}
