<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Pemeriksaan
{
    private static ?array $cachedColumns = null;

    private static function columns(): array
    {
        if (self::$cachedColumns !== null) {
            return self::$cachedColumns;
        }
        try {
            $pdo = Database::pdo();
            $stmt = $pdo->query('SHOW COLUMNS FROM pemeriksaan');
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            self::$cachedColumns = array_map(static function ($r) { return $r['Field']; }, $rows ?: []);
        } catch (\Throwable $e) {
            // Fallback to the intended schema if introspection fails
            self::$cachedColumns = [
                'id','lansia_id','petugas_id','tgl_periksa','tinggi_cm','berat_kg','sistolik','diastolik','tekanan_darah_kategori','bmi','bmi_kategori',
                'asam_urat_mgdl','asam_urat_kategori','gula_mgdl','gula_tipe','gula_kategori','kolesterol_total_mgdl','kolesterol_total_kategori','catatan','created_at','updated_at'
            ];
        }
        return self::$cachedColumns;
    }

    public static function create(array $data): int
    {
        $pdo = Database::pdo();

        $available = self::columns();

        // Map logical fields to physical column names (support fallbacks)
        $fieldMap = [
            'lansia_id' => ['lansia_id'],
            'petugas_id' => ['petugas_id'],
            'tgl_periksa' => ['tgl_periksa'],
            'tinggi_cm' => ['tinggi_cm'],
            'berat_kg' => ['berat_kg'],
            'sistolik' => ['sistolik'],
            'diastolik' => ['diastolik'],
            'tekanan_darah_kategori' => ['tekanan_darah_kategori'],
            'bmi' => ['bmi'],
            'bmi_kategori' => ['bmi_kategori'],
            'asam_urat_mgdl' => ['asam_urat_mgdl'],
            'asam_urat_kategori' => ['asam_urat_kategori'],
            'gula_mgdl' => ['gula_mgdl'],
            'gula_tipe' => ['gula_tipe'],
            'gula_kategori' => ['gula_kategori'],
            // Prefer new names; fall back to legacy kolesterol_mgdl if needed
            'kolesterol_total_mgdl' => ['kolesterol_total_mgdl', 'kolesterol_mgdl'],
            'kolesterol_total_kategori' => ['kolesterol_total_kategori'],
            'catatan' => ['catatan'],
        ];

        $cols = [];
        $placeholders = [];
        $params = [];
        foreach ($fieldMap as $logical => $choices) {
            // Only include fields provided in $data (except tgl_periksa which we always set)
            $hasValue = array_key_exists($logical, $data);
            $physicalValue = null;
            if (!$hasValue) {
                // Also allow specifying via physical keys
                foreach ($choices as $c) {
                    if (array_key_exists($c, $data)) { $hasValue = true; $physicalValue = $data[$c]; break; }
                }
            } else {
                $physicalValue = $data[$logical];
            }
            if ($logical === 'tgl_periksa') { $hasValue = true; }

            if (!$hasValue) { continue; }

            // Find first available physical column
            $physical = null;
            foreach ($choices as $c) {
                if (in_array($c, $available, true)) { $physical = $c; break; }
            }
            if (!$physical) { continue; }
            $cols[] = $physical;
            if ($physical === 'tgl_periksa') {
                $placeholders[] = 'NOW()';
            } else {
                $ph = ':' . $physical;
                $placeholders[] = $ph;
                $params[$ph] = $physicalValue;
            }
        }

        if (!$cols) {
            throw new \InvalidArgumentException('No data to insert');
        }

        $sql = 'INSERT INTO pemeriksaan (' . implode(', ', $cols) . ') VALUES (' . implode(', ', $placeholders) . ')';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return (int)$pdo->lastInsertId();
    }

    public static function updateById(int $id, array $data): void
    {
        if ($id <= 0) { throw new \InvalidArgumentException('Invalid id'); }
        $pdo = Database::pdo();
        $available = self::columns();

        $fieldMap = [
            'tinggi_cm' => ['tinggi_cm'],
            'berat_kg' => ['berat_kg'],
            'sistolik' => ['sistolik'],
            'diastolik' => ['diastolik'],
            'tekanan_darah_kategori' => ['tekanan_darah_kategori'],
            'bmi' => ['bmi'],
            'bmi_kategori' => ['bmi_kategori'],
            'asam_urat_mgdl' => ['asam_urat_mgdl'],
            'asam_urat_kategori' => ['asam_urat_kategori'],
            'gula_mgdl' => ['gula_mgdl'],
            'gula_tipe' => ['gula_tipe'],
            'gula_kategori' => ['gula_kategori'],
            'kolesterol_total_mgdl' => ['kolesterol_total_mgdl', 'kolesterol_mgdl'],
            'kolesterol_total_kategori' => ['kolesterol_total_kategori'],
            'catatan' => ['catatan'],
        ];

        $sets = [];
        $params = [':id' => $id];
        foreach ($fieldMap as $logical => $choices) {
            if (!array_key_exists($logical, $data)) {
                // allow physical key
                $valSet = false; $val = null; $phys = null;
                foreach ($choices as $c) {
                    if (array_key_exists($c, $data)) { $valSet = true; $val = $data[$c]; $phys = $c; break; }
                }
                if (!$valSet) { continue; }
            } else {
                $val = $data[$logical];
                // choose first available physical
                $phys = null; foreach ($choices as $c) { if (in_array($c, $available, true)) { $phys = $c; break; } }
            }
            if (!$phys || !in_array($phys, $available, true)) { continue; }
            $ph = ':' . $phys;
            $sets[] = "`$phys` = $ph";
            $params[$ph] = $val;
        }

        if (!$sets) { return; }
        $sql = 'UPDATE pemeriksaan SET ' . implode(', ', $sets) . ', updated_at = NOW() WHERE id = :id';
        $st = $pdo->prepare($sql);
        $st->execute($params);
    }

    public static function upsertForToday(int $lansiaId, array $data): int
    {
        $pdo = Database::pdo();
        // Find the latest pemeriksaan for this lansia today
        $sql = 'SELECT id FROM pemeriksaan WHERE lansia_id = :lid AND tgl_periksa >= CURRENT_DATE AND tgl_periksa < CURRENT_DATE + INTERVAL 1 DAY ORDER BY tgl_periksa DESC, id DESC LIMIT 1';
        $st = $pdo->prepare($sql);
        $st->execute([':lid' => $lansiaId]);
        $id = (int)($st->fetchColumn() ?: 0);
        if ($id > 0) {
            self::updateById($id, $data);
            return $id;
        }
        // Create new row with lansia_id and provided fields
        $payload = array_merge(['lansia_id' => $lansiaId], $data);
        return self::create($payload);
    }

    /**
     * Ambil riwayat pemeriksaan untuk satu lansia (terbaru dulu)
     */
    public static function listByLansia(int $lansiaId, int $limit = 10): array
    {
        if ($lansiaId <= 0) return [];
        $pdo = Database::pdo();

        // Build SELECT fields defensively based on available columns
        $avail = self::columns();
        $has = static function(string $c) use ($avail): bool { return in_array($c, $avail, true); };
        // Prefix pemeriksaan table alias `p` for existing columns; fallback to NULL as alias
        $pf = static function(string $c, ?string $alias = null) use ($has): string {
            return $has($c) ? ('p.`' . $c . '`') : ('NULL AS ' . ($alias ?? $c));
        };

        $fields = [
            'p.`id`', 'p.`lansia_id`', 'p.`tgl_periksa`',
            $pf('tinggi_cm'),
            $pf('berat_kg'),
            $pf('sistolik'),
            $pf('diastolik'),
            $pf('tekanan_darah_kategori'),
            $pf('bmi'),
            $pf('bmi_kategori'),
            $pf('asam_urat_mgdl'),
            $pf('asam_urat_kategori'),
            $pf('gula_mgdl'),
            $pf('gula_tipe'),
            $pf('gula_kategori'),
            $pf('petugas_id'),
        ];

        // Cholesterol (support legacy kolesterol_mgdl)
        $cholExpr = null;
        $hasTotal = $has('kolesterol_total_mgdl');
        $hasLegacy = $has('kolesterol_mgdl');
        if ($hasTotal && $hasLegacy) {
            $cholExpr = 'COALESCE(p.`kolesterol_total_mgdl`, p.`kolesterol_mgdl`) AS kolesterol_total_mgdl';
        } elseif ($hasTotal) {
            $cholExpr = 'p.`kolesterol_total_mgdl`';
        } elseif ($hasLegacy) {
            $cholExpr = 'p.`kolesterol_mgdl` AS kolesterol_total_mgdl';
        } else {
            $cholExpr = 'NULL AS kolesterol_total_mgdl';
        }
        $fields[] = $cholExpr;
        $fields[] = $pf('kolesterol_total_kategori');
        $fields[] = $pf('catatan');
        // Petugas name (nullable)
        $fields[] = 'u.`nama` AS petugas_nama';

        $sql = 'SELECT ' . implode(', ', $fields) . ' FROM pemeriksaan p '
             . 'LEFT JOIN users u ON u.id = p.petugas_id '
             . 'WHERE p.lansia_id = :lid ORDER BY p.tgl_periksa DESC, p.id DESC LIMIT :lim';
        $st = $pdo->prepare($sql);
        $st->bindValue(':lid', $lansiaId, PDO::PARAM_INT);
        $st->bindValue(':lim', max(1, $limit), PDO::PARAM_INT);
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC) ?: [];
        return $rows;
    }
}
