<?php
$errors = $errors ?? [];
$old = $old ?? [];
$success = $success ?? null;
$csrfToken = $_SESSION['csrf_token'] ?? '';
?>

<div class="max-w-xl mx-auto">
  <div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Tambah Petugas</h1>
    <p class="text-sm text-gray-600 mt-1">Hanya admin yang dapat menambahkan petugas baru.</p>
  </div>

  <?php if ($success): ?>
    <div class="alert alert-success mb-6">
      <?= htmlspecialchars($success) ?>
    </div>
  <?php endif; ?>

  <form method="post" action="/petugas" class="card p-6 space-y-5">
    <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrfToken) ?>">

    <div>
      <label for="nama" class="form-label required">Nama Petugas</label>
      <input id="nama" name="nama" type="text" class="form-input <?= isset($errors['nama']) ? 'error' : '' ?>" placeholder="Masukkan nama petugas" value="<?= htmlspecialchars($old['nama'] ?? '') ?>" required>
      <?php if (isset($errors['nama'])): ?>
        <div class="form-error">
          <span><?= htmlspecialchars($errors['nama']) ?></span>
        </div>
      <?php else: ?>
        <p class="form-help">Maksimal 150 karakter.</p>
      <?php endif; ?>
    </div>

    <div>
      <label for="password" class="form-label required">Kata Sandi</label>
      <input id="password" name="password" type="password" class="form-input <?= isset($errors['password']) ? 'error' : '' ?>" placeholder="Minimal 8 karakter" required>
      <?php if (isset($errors['password'])): ?>
        <div class="form-error">
          <span><?= htmlspecialchars($errors['password']) ?></span>
        </div>
      <?php else: ?>
        <p class="form-help">Kata sandi akan disimpan secara aman (hash).</p>
      <?php endif; ?>
    </div>

    <div class="flex items-center gap-2">
      <input id="aktif" name="aktif" type="checkbox" class="form-checkbox" <?= ($old['aktif'] ?? 1) ? 'checked' : '' ?>>
      <label for="aktif" class="text-sm text-gray-700">Aktif</label>
    </div>

    <div class="flex items-center gap-3">
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="/" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>

