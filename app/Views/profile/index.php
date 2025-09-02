<?php
$me = $me ?? ($_SESSION['user'] ?? []);
?>

<div class="max-w-2xl mx-auto space-y-6">
  <div class="text-center">
    <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-600 text-white font-bold text-2xl shadow-lg"><?= htmlspecialchars(strtoupper(substr($me['nama'] ?? 'U', 0, 1))) ?></div>
    <h1 class="mt-4 text-2xl font-bold text-gray-900">Profil Saya</h1>
    <p class="text-sm text-gray-600">Informasi akun pengguna</p>
  </div>

  <div class="grid md:grid-cols-2 gap-6">
    <div class="card p-6">
      <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Akun</h2>
      <dl class="text-sm text-gray-700 space-y-3">
        <div class="flex justify-between"><dt class="text-gray-600">Nama</dt><dd class="font-medium text-gray-900"><?= htmlspecialchars($me['nama'] ?? '-') ?></dd></div>
        <div class="flex justify-between"><dt class="text-gray-600">Peran</dt><dd class="font-medium text-gray-900"><?= htmlspecialchars($me['role'] ?? '-') ?></dd></div>
        <div class="flex justify-between"><dt class="text-gray-600">Status</dt><dd class="font-medium text-gray-900"><?= (int)($me['aktif'] ?? 1) ? 'Aktif' : 'Nonaktif' ?></dd></div>
        <div class="flex justify-between"><dt class="text-gray-600">Dibuat</dt><dd class="font-medium text-gray-900"><?= htmlspecialchars($me['created_at'] ?? '-') ?></dd></div>
        <div class="flex justify-between"><dt class="text-gray-600">Diperbarui</dt><dd class="font-medium text-gray-900"><?= htmlspecialchars($me['updated_at'] ?? '-') ?></dd></div>
      </dl>
    </div>

    <div class="card p-6">
      <h2 class="text-lg font-semibold text-gray-900 mb-4">Keamanan</h2>
      <p class="text-sm text-gray-600">Anda dapat memperbarui nama dan kata sandi akun Anda.</p>
      <div class="mt-4 flex flex-col sm:flex-row gap-3">
        <a href="/profil/edit" class="btn btn-primary">Ubah Profil / Kata Sandi</a>
        <a href="/" class="btn btn-secondary">Kembali ke Beranda</a>
      </div>
    </div>
  </div>
</div>
