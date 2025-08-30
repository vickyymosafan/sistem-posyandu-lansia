<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Lansia
{
    public static function existsByNama(string $nama): bool
    {
        $pdo = Database::pdo();
        $stmt = $pdo->prepare('SELECT 1 FROM lansia WHERE LOWER(nama_lengkap) = LOWER(:n) LIMIT 1');
        $stmt->execute([':n' => trim($nama)]);
        return (bool)$stmt->fetchColumn();
    }
    public static function create(array $data): int
    {
        $pdo = Database::pdo();
        $stmt = $pdo->prepare("INSERT INTO lansia (id_unik, nama_lengkap, tgl_lahir, jk, alamat, no_telp, created_at, updated_at) VALUES (:id_unik, :nama_lengkap, :tgl_lahir, :jk, :alamat, :no_telp, NOW(), NOW())");
        $stmt->execute([
            ':id_unik' => $data['id_unik'],
            ':nama_lengkap' => $data['nama_lengkap'],
            ':tgl_lahir' => $data['tgl_lahir'],
            ':jk' => $data['jk'],
            ':alamat' => $data['alamat'],
            ':no_telp' => $data['no_telp'],
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function findByKode(string $kode): ?array
    {
        $pdo = Database::pdo();
        $stmt = $pdo->prepare('SELECT * FROM lansia WHERE id_unik = :kode LIMIT 1');
        $stmt->execute([':kode' => $kode]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function paginate(int $page = 1, int $perPage = 20, ?string $q = null): array
    {
        $page = max(1, $page);
        $perPage = max(1, min(100, $perPage));
        $offset = ($page - 1) * $perPage;

        $pdo = Database::pdo();

        $where = '';
        $params = [];
        if ($q !== null && trim($q) !== '') {
            $qLike = '%' . $q . '%';
            // Use unique parameter names for native prepared statements (emulate prepares = false)
            $where = 'WHERE nama_lengkap LIKE :q1 OR id_unik LIKE :q2';
            $params[':q1'] = $qLike;
            $params[':q2'] = $qLike;
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) AS c FROM lansia $where");
        $stmt->execute($params);
        $total = (int)($stmt->fetch(PDO::FETCH_ASSOC)['c'] ?? 0);

        $sql = "SELECT id_unik, nama_lengkap, tgl_lahir, jk, no_telp, created_at FROM lansia $where ORDER BY created_at DESC LIMIT :lim OFFSET :off";
        $stmt = $pdo->prepare($sql);
        foreach ($params as $k => $v) { $stmt->bindValue($k, $v, PDO::PARAM_STR); }
        $stmt->bindValue(':lim', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':off', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        $pages = (int)max(1, (int)ceil($total / $perPage));
        if ($page > $pages) { $page = $pages; }

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'pages' => $pages,
        ];
    }
}
