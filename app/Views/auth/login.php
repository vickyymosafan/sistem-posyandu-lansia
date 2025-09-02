<?php
$error = $error ?? null;
$oldNama = $old['nama'] ?? '';
$csrfToken = $csrf ?? ($_SESSION['csrf_token'] ?? '');
$next = $next ?? '/';
?>

<div class="min-h-[80vh] flex items-center justify-center">
  <div class="w-full max-w-md">
    <div class="text-center mb-8 animate-fade-in">
      <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-white font-bold text-lg shadow-lg">PL</div>
      <h1 class="mt-4 text-2xl font-bold text-gray-900">Login Admin</h1>
      <p class="mt-1 text-sm text-gray-600">Sistem Posyandu Lansia</p>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger animate-shake">
        <div class="flex items-start gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-red-600 flex-none" aria-hidden="true"><path fill-rule="evenodd" d="M10.29 3.86a2.25 2.25 0 013.42 0l7.8 9.75c1.2 1.5.11 3.69-1.71 3.69H4.2c-1.82 0-2.9-2.19-1.71-3.69l7.8-9.75zM12 9a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0112 9zm0 7a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/></svg>
          <div class="text-sm">
            <?= htmlspecialchars($error) ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <form method="post" action="/login" class="card p-6 space-y-5 animate-slide-up" autocomplete="off" novalidate>
      <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrfToken) ?>">
      <input type="hidden" name="next" value="<?= htmlspecialchars($next) ?>">

      <div>
        <label for="nama" class="form-label required">Nama Admin</label>
        <input id="nama" name="nama" type="text" inputmode="text" class="form-input" placeholder="Masukkan nama admin" required value="<?= htmlspecialchars($oldNama) ?>" autofocus>
      </div>

      <div>
        <label for="password" class="form-label required">Kata Sandi</label>
        <input id="password" name="password" type="password" class="form-input" placeholder="Masukkan kata sandi" required>
      </div>

      <button type="submit" class="btn btn-primary w-full" aria-label="Masuk ke dashboard admin">
        <span class="btn-text">Masuk</span>
      </button>

      <p class="text-xs text-gray-500 text-center">Hanya admin yang dapat mengakses aplikasi ini.</p>
    </form>

    <div class="mt-6 text-center text-xs text-gray-500">
      <p>&copy; <?= date('Y') ?> Posyandu Lansia</p>
    </div>
  </div>
</div>

