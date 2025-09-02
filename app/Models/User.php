<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    public static function findActiveByNamaAndRole(string $nama, string $role = 'admin'): ?array
    {
        $pdo = Database::pdo();
        $sql = 'SELECT id, nama, role, password_hash, aktif, created_at, updated_at FROM users WHERE nama = :n AND role = :r AND aktif = 1 LIMIT 1';
        $st = $pdo->prepare($sql);
        $st->execute([':n' => $nama, ':r' => $role]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function findActiveByNama(string $nama): ?array
    {
        $pdo = Database::pdo();
        $sql = 'SELECT id, nama, role, password_hash, aktif, created_at, updated_at FROM users WHERE nama = :n AND aktif = 1 LIMIT 1';
        $st = $pdo->prepare($sql);
        $st->execute([':n' => $nama]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function existsByNamaRole(string $nama, string $role): bool
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare('SELECT 1 FROM users WHERE LOWER(nama) = LOWER(:n) AND role = :r LIMIT 1');
        $st->execute([':n' => trim($nama), ':r' => $role]);
        return (bool)$st->fetchColumn();
    }

    public static function createPetugas(string $nama, string $password, int $aktif = 1): int
    {
        $pdo = Database::pdo();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $st = $pdo->prepare('INSERT INTO users (nama, role, password_hash, aktif, created_at, updated_at) VALUES (:n, :role, :h, :a, NOW(), NOW())');
        $st->execute([
            ':n' => $nama,
            ':role' => 'petugas',
            ':h' => $hash,
            ':a' => $aktif ? 1 : 0,
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function findById(int $id): ?array
    {
        if ($id <= 0) return null;
        $pdo = Database::pdo();
        $st = $pdo->prepare('SELECT id, nama, role, aktif, created_at, updated_at FROM users WHERE id = :id LIMIT 1');
        $st->execute([':id' => $id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function existsByNamaExceptId(string $nama, int $excludeId): bool
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare('SELECT 1 FROM users WHERE LOWER(nama) = LOWER(:n) AND id <> :id LIMIT 1');
        $st->execute([':n' => trim($nama), ':id' => $excludeId]);
        return (bool)$st->fetchColumn();
    }

    public static function updateNama(int $id, string $nama): void
    {
        if ($id <= 0) { throw new \InvalidArgumentException('Invalid id'); }
        $pdo = Database::pdo();
        $st = $pdo->prepare('UPDATE users SET nama = :n, updated_at = NOW() WHERE id = :id');
        $st->execute([':n' => $nama, ':id' => $id]);
    }

    public static function updatePassword(int $id, string $newPassword): void
    {
        if ($id <= 0) { throw new \InvalidArgumentException('Invalid id'); }
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $pdo = Database::pdo();
        $st = $pdo->prepare('UPDATE users SET password_hash = :h, updated_at = NOW() WHERE id = :id');
        $st->execute([':h' => $hash, ':id' => $id]);
    }
}
