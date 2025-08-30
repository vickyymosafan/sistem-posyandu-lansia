<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Lansia;
use App\Models\Pemeriksaan;
use App\Validation\Validator;

class PemeriksaanController extends Controller
{
    public function form(string $kode): void
    {
        $l = Lansia::findByKode($kode);
        if (!$l) { http_response_code(404); echo 'Lansia tidak ditemukan'; return; }
        $this->view('pemeriksaan/form', [
            'title' => 'Pemeriksaan Lansia',
            'l' => $l,
            'success' => $_SESSION['success'] ?? null,
            'errors_fisik' => $_SESSION['errors_fisik'] ?? [],
            'errors_kesehatan' => $_SESSION['errors_kesehatan'] ?? [],
            'old_fisik' => $_SESSION['old_fisik'] ?? [],
            'old_kesehatan' => $_SESSION['old_kesehatan'] ?? [],
        ]);
        unset($_SESSION['success'], $_SESSION['errors_fisik'], $_SESSION['errors_kesehatan'], $_SESSION['old_fisik'], $_SESSION['old_kesehatan']);
    }

    public function storeFisik(string $kode): void
    {
        $l = Lansia::findByKode($kode);
        if (!$l) { http_response_code(404); echo 'Lansia tidak ditemukan'; return; }

        $input = [
            'tinggi_cm' => trim((string)($_POST['tinggi_cm'] ?? '')),
            'berat_kg' => trim((string)($_POST['berat_kg'] ?? '')),
            'sistolik' => trim((string)($_POST['sistolik'] ?? '')),
            'diastolik' => trim((string)($_POST['diastolik'] ?? '')),
        ];

        $v = new Validator($input);
        // Ranges
        $this->numRange($v, 'tinggi_cm', 100, 200, 'Tinggi badan (cm)');
        $this->numRange($v, 'berat_kg', 30, 150, 'Berat badan (kg)');
        $this->numRange($v, 'sistolik', 70, 250, 'Tekanan darah sistolik (mmHg)');
        $this->numRange($v, 'diastolik', 40, 150, 'Tekanan darah diastolik (mmHg)');

        if (!$v->passes()) {
            $_SESSION['errors_fisik'] = $v->errors();
            $_SESSION['old_fisik'] = $input;
            $this->redirect('/lansia/' . $kode . '/pemeriksaan');
            return;
        }

        $tinggi = (int)$input['tinggi_cm'];
        $berat = (float)$input['berat_kg'];
        $bmi = round($berat / pow($tinggi/100, 2), 1);

        // Kategori BMI (pakem Indonesia/Asia Pasifik)
        // <17.0: SANGAT_KURANG
        // 17.0–18.4: KURANG
        // 18.5–25.0: NORMAL
        // 25.1–27.0: LEBIH
        // 27.1–30.0: OBESITAS_I
        // >30.0: OBESITAS_II
        $bmiKategori = null;
        if ($bmi < 17.0) { $bmiKategori = 'SANGAT_KURANG'; }
        elseif ($bmi < 18.5) { $bmiKategori = 'KURANG'; }
        elseif ($bmi <= 25.0) { $bmiKategori = 'NORMAL'; }
        elseif ($bmi <= 27.0) { $bmiKategori = 'LEBIH'; }
        elseif ($bmi <= 30.0) { $bmiKategori = 'OBESITAS_I'; }
        else { $bmiKategori = 'OBESITAS_II'; }

        // Klasifikasi Tekanan Darah (AHA) - ambil kategori tertinggi
        $sys = (int)$input['sistolik'];
        $dia = (int)$input['diastolik'];
        $bpEnum = 'NORMAL';
        if ($sys > 180 || $dia > 120) {
            $bpEnum = 'KRISIS_HIPERTENSI';
        } elseif ($sys >= 140 || $dia >= 90) {
            $bpEnum = 'HIPERTENSI_TAHAP_2';
        } elseif ($sys >= 130 || ($dia >= 80 && $dia <= 89)) {
            $bpEnum = 'HIPERTENSI_TAHAP_1';
        } elseif ($sys >= 120 && $sys <= 129 && $dia < 80) {
            $bpEnum = 'BATAS_WASPADA';
        } else {
            $bpEnum = 'NORMAL';
        }

        Pemeriksaan::upsertForToday((int)$l['id'], [
            'tinggi_cm' => $tinggi,
            'berat_kg' => $berat,
            'sistolik' => $sys,
            'diastolik' => $dia,
            'tekanan_darah_kategori' => $bpEnum,
            'bmi' => $bmi,
            'bmi_kategori' => $bmiKategori,
        ]);

        $bmiLabelMap = [
            'SANGAT_KURANG' => 'Berat Badan Sangat Kurang',
            'KURANG' => 'Berat Badan Kurang',
            'NORMAL' => 'Berat Badan Normal',
            'LEBIH' => 'Kelebihan Berat Badan (Overweight)',
            'OBESITAS_I' => 'Obesitas Tingkat I',
            'OBESITAS_II' => 'Obesitas Tingkat II',
        ];
        $bmiLabel = $bmiLabelMap[$bmiKategori] ?? '';
        $bpLabelMap = [
            'NORMAL' => 'Normal',
            'BATAS_WASPADA' => 'Batas Waspada (Elevated)',
            'HIPERTENSI_TAHAP_1' => 'Hipertensi Tahap 1',
            'HIPERTENSI_TAHAP_2' => 'Hipertensi Tahap 2',
            'KRISIS_HIPERTENSI' => 'Krisis Hipertensi',
        ];
        $bpLabel = $bpLabelMap[$bpEnum] ?? $bpEnum;

        $_SESSION['success'] = 'Pemeriksaan fisik tersimpan. BMI: ' . $bmi . ($bmiLabel ? ' (' . $bmiLabel . ')' : '')
            . '. Tekanan darah: ' . $sys . '/' . $dia . ' mmHg (' . $bpLabel . ')';
        $this->redirect('/lansia/' . $kode . '/pemeriksaan');
        return;
    }

    public function storeKesehatan(string $kode): void
    {
        $l = Lansia::findByKode($kode);
        if (!$l) { http_response_code(404); echo 'Lansia tidak ditemukan'; return; }

        $input = [
            'asam_urat_mgdl' => trim((string)($_POST['asam_urat_mgdl'] ?? '')),
            'gula_mgdl' => trim((string)($_POST['gula_mgdl'] ?? '')),
            'gula_tipe' => trim((string)($_POST['gula_tipe'] ?? '')),
            'kolesterol_total_mgdl' => trim((string)($_POST['kolesterol_total_mgdl'] ?? '')),
        ];

        $v = new Validator($input);
        // DB enum uses: 'puasa' | 'sewaktu' | '2jpp'
        $v->required('gula_tipe', 'Tipe pemeriksaan gula')->enum('gula_tipe', ['puasa','sewaktu','2jpp'], 'Tipe pemeriksaan gula');
        $this->numRange($v, 'asam_urat_mgdl', 2.0, 15.0, 'Asam urat (mg/dL)', true);
        $this->numRange($v, 'gula_mgdl', 50, 500, 'Gula darah (mg/dL)');
        $this->numRange($v, 'kolesterol_total_mgdl', 100, 400, 'Kolesterol total (mg/dL)');

        if (!$v->passes()) {
            $_SESSION['errors_kesehatan'] = $v->errors();
            $_SESSION['old_kesehatan'] = $input;
            $this->redirect('/lansia/' . $kode . '/pemeriksaan');
            return;
        }

        // Klasifikasi gula darah untuk penyimpanan (sesuai pakem)
        $gulaKategori = null;
        $gulaVal = (int)$input['gula_mgdl'];
        $gulaTipe = $input['gula_tipe'];
        // Map to clinical rules by DB value
        if ($gulaTipe === 'puasa') { // GDP
            if ($gulaVal >= 126) { $gulaKategori = 'DIABETES'; }
            elseif ($gulaVal >= 100) { $gulaKategori = 'PRA_DIABETES'; }
            else { $gulaKategori = 'NORMAL'; }
        } elseif ($gulaTipe === '2jpp') { // 2JAMPP
            if ($gulaVal >= 200) { $gulaKategori = 'DIABETES'; }
            elseif ($gulaVal >= 140) { $gulaKategori = 'PRA_DIABETES'; }
            else { $gulaKategori = 'NORMAL'; }
        } elseif ($gulaTipe === 'sewaktu') { // GDS
            // Sesuai arahan: tidak ada 'curiga diabetes'.
            // GDS >= 200 mg/dL diklasifikasikan sebagai DIABETES (dengan catatan gejala khas pada pesan saja)
            if ($gulaVal >= 200) { $gulaKategori = 'DIABETES'; }
            else { $gulaKategori = 'NORMAL'; }
        }

        // Keterangan kolesterol total (pakem)
        $kolTotal = (int)$input['kolesterol_total_mgdl'];
        $kolCat = $kolTotal >= 240 ? 'Tinggi' : ($kolTotal >= 200 ? 'Batas tinggi' : 'Normal');
        $kolCatEnum = $kolTotal >= 240 ? 'TINGGI' : ($kolTotal >= 200 ? 'BATAS_TINGGI' : 'NORMAL');

        // Keterangan asam urat berdasar jenis kelamin
        $asam = (float)$input['asam_urat_mgdl'];
        $low = ($l['jk'] ?? 'L') === 'L' ? 3.4 : 2.4;
        $high = ($l['jk'] ?? 'L') === 'L' ? 7.0 : 6.0;
        $asamCat = $asam < $low ? 'Rendah' : ($asam > $high ? 'Tinggi' : 'Normal');
        $asamCatEnum = $asam < $low ? 'RENDAH' : ($asam > $high ? 'TINGGI' : 'NORMAL');

        Pemeriksaan::upsertForToday((int)$l['id'], [
            'asam_urat_mgdl' => (float)$input['asam_urat_mgdl'],
            'asam_urat_kategori' => $asamCatEnum,
            'gula_mgdl' => (int)$input['gula_mgdl'],
            'gula_tipe' => $input['gula_tipe'] !== '' ? $input['gula_tipe'] : null,
            'gula_kategori' => $gulaKategori,
            'kolesterol_total_mgdl' => $input['kolesterol_total_mgdl'] !== '' ? (int)$input['kolesterol_total_mgdl'] : null,
            'kolesterol_total_kategori' => $kolCatEnum,
        ]);

        $mapLabel = ['puasa' => 'GDP (Puasa)', 'sewaktu' => 'GDS (Sewaktu)', '2jpp' => '2 Jam Setelah Makan'];
        $gtLabel = $mapLabel[$gulaTipe] ?? $gulaTipe;
        $parts = [];
        $gulaNote = '';
        if ($gulaTipe === 'sewaktu' && $gulaKategori === 'DIABETES') {
            $gulaNote = ' - Diagnosis GDS memerlukan gejala khas (haus, sering BAK, penurunan BB)';
        }
        $parts[] = 'Gula: ' . $gulaVal . ' mg/dL (' . $gtLabel . ($gulaKategori ? ' => ' . $gulaKategori : '') . ')' . $gulaNote;
        $parts[] = 'Kolesterol Total: ' . $kolTotal . ' mg/dL (' . $kolCat . ')';
        $parts[] = 'Asam Urat: ' . $asam . ' mg/dL (' . $asamCat . ')';
        $_SESSION['success'] = 'Pemeriksaan kesehatan tersimpan. ' . implode('; ', $parts);
        $this->redirect('/lansia/' . $kode . '/pemeriksaan');
        return;
    }

    private function numRange(Validator $v, string $field, $min, $max, string $label, bool $isFloat = false, bool $required = true): void
    {
        // Optional support
        $raw = $_POST[$field] ?? null;
        if (!$required && ($raw === null || trim((string)$raw) === '')) {
            return; // skip optional empty field
        }

        // Numeric pattern
        $pattern = $isFloat ? '/^\d+(?:\.\d+)?$/' : '/^\d+$/';
        if ($required) {
            $v->required($field, $label);
        }
        $v->regex($field, $pattern, $label . ' harus numerik');

        $errs = $v->errors();
        if (!isset($errs[$field])) {
            if ($raw !== null) {
                $num = $isFloat ? (float)$raw : (int)$raw;
                if ($num < $min || $num > $max) {
                    $v->regex($field, '/a^/', sprintf('%s harus antara %s dan %s', $label, $min, $max));
                }
            }
        }
    }
}
