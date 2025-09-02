<?php
$me = $me ?? ($_SESSION['user'] ?? []);
$errors = $errors ?? [];
$success = $success ?? null;
$old = $old ?? [];
$csrfToken = $_SESSION['csrf_token'] ?? '';
?>

<div class="max-w-2xl mx-auto space-y-8">
  <div class="text-center">
    <h1 class="text-2xl font-bold text-gray-900">Ubah Profil</h1>
    <p class="text-sm text-gray-600">Perbarui informasi akun Anda</p>
  </div>

  <?php if ($success): ?>
    <div class="alert alert-success">
      <?= htmlspecialchars($success) ?>
    </div>
  <?php endif; ?>

  <!-- Ubah Nama -->
  <div class="card p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Ubah Nama</h2>
    <form method="post" action="/profil/nama" class="space-y-4">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrfToken) ?>">
      <div>
        <label for="nama" class="form-label required">Nama</label>
        <input id="nama" name="nama" type="text" class="form-input <?= isset($errors['nama']) ? 'error' : '' ?>" value="<?= htmlspecialchars($old['nama'] ?? ($me['nama'] ?? '')) ?>" required>
        <?php if (isset($errors['nama'])): ?>
          <div class="form-error"><span><?= htmlspecialchars($errors['nama']) ?></span></div>
        <?php else: ?>
          <p class="form-help">Maksimal 150 karakter, gunakan nama yang mudah dikenali.</p>
        <?php endif; ?>
      </div>
      <div class="flex items-center gap-3">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/profil" class="btn btn-secondary">Batal</a>
      </div>
    </form>
  </div>

  <!-- Ubah Kata Sandi -->
  <div class="card p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Ubah Kata Sandi</h2>
    <form method="post" action="/profil/password" class="space-y-4" autocomplete="off">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrfToken) ?>">
      <div>
        <label for="current_password" class="form-label required">Kata Sandi Saat Ini</label>
        <input id="current_password" name="current_password" type="password" class="form-input <?= isset($errors['current']) ? 'error' : '' ?>" required>
        <?php if (isset($errors['current'])): ?>
          <div class="form-error"><span><?= htmlspecialchars($errors['current']) ?></span></div>
        <?php endif; ?>
      </div>
      <div>
        <label for="new_password" class="form-label required">Kata Sandi Baru</label>
        <input id="new_password" name="new_password" type="password" class="form-input <?= isset($errors['new']) ? 'error' : '' ?>" placeholder="Minimal 8 karakter" required>
        <?php if (isset($errors['new'])): ?>
          <div class="form-error"><span><?= htmlspecialchars($errors['new']) ?></span></div>
        <?php endif; ?>
      </div>
      <div>
        <label for="confirm_password" class="form-label required">Konfirmasi Kata Sandi Baru</label>
        <input id="confirm_password" name="confirm_password" type="password" class="form-input <?= isset($errors['confirm']) ? 'error' : '' ?>" required>
        <?php if (isset($errors['confirm'])): ?>
          <div class="form-error"><span><?= htmlspecialchars($errors['confirm']) ?></span></div>
        <?php endif; ?>
      </div>
      <div class="flex items-center gap-3">
        <button type="submit" class="btn btn-primary">Perbarui Kata Sandi</button>
      </div>
    </form>
  </div>
</div>

