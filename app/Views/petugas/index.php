<?php
// $items, $page, $pages, $total, $q, $perPage, $success?, $error?
$q = $q ?? '';
$success = $success ?? null;
$error = $error ?? null;
?>

<div class="space-y-4">
  <!-- Back Button -->
  <div>
    <a href="/" onclick="haptic(); if (history.length>1) { history.back(); return false; }" class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
      </svg>
      Kembali
    </a>
  </div>

  <div class="flex items-center justify-between gap-4 flex-wrap">
    <div>
      <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-900">Data Petugas</h1>
      <p class="text-gray-600 mt-1">Daftar semua akun petugas yang terdaftar</p>
    </div>

    <div class="flex items-center gap-3 w-full sm:w-auto">
      <!-- Search Form -->
      <form method="get" class="flex items-center gap-3 w-full sm:w-auto" onsubmit="return handleListSearchSubmit(this)" role="search" aria-label="Pencarian petugas">
        <div class="relative flex-1 min-w-0 sm:flex-none sm:min-w-[260px] group">
          <label for="searchInput" class="sr-only">Cari petugas</label>
          <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-150" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
              <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
            </svg>
          </span>
          <input class="form-input pl-10 pr-12 text-sm py-3 bg-white border-gray-300 hover:border-gray-400 focus:border-blue-500 focus:ring-blue-500 transition-all duration-150"
                 type="search"
                 name="q"
                 id="searchInput"
                 placeholder="Cari nama petugas..."
                 autocomplete="off"
                 value="<?= htmlspecialchars($q) ?>"
                 oninput="handleSearchInputChange(this)"
                 aria-describedby="search-help"
                 role="searchbox"
                 aria-label="Masukkan nama petugas untuk mencari">

          <?php if (!empty($q)): ?>
          <button type="button"
                  class="absolute right-12 top-1/2 -translate-y-1/2 p-1 rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-all duration-150"
                  onclick="clearSearch()"
                  aria-label="Hapus pencarian"
                  title="Hapus pencarian">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" aria-hidden="true">
              <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
            </svg>
          </button>
          <?php endif; ?>

          <div id="search-help" class="sr-only">Gunakan kotak pencarian untuk mencari petugas berdasarkan nama</div>

          <div class="absolute right-3 top-1/2 -translate-y-1/2 hidden" id="searchLoading">
            <svg class="animate-spin h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
          </div>
        </div>
        <button class="btn btn-primary btn-micro text-sm px-5 py-3 font-medium shadow-sm hover:shadow-md transition-all duration-150 flex-none" type="submit" id="searchBtn" onclick="haptic()">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
          </svg>
          <span class="hidden sm:inline">Cari</span>
          <span class="sm:hidden">Cari</span>
        </button>
      </form>

      <a href="/petugas/create" class="btn btn-outline-primary whitespace-nowrap" onclick="haptic()">Tambah Petugas</a>
    </div>
  </div>

  <div class="bg-white border border-gray-200 rounded-xl shadow-card overflow-hidden" role="region" aria-labelledby="table-title">
    <?php if ($success): ?>
      <div class="px-4 pt-4">
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
      </div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="px-4 pt-4">
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      </div>
    <?php endif; ?>
    <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
      <div>
        <h2 id="table-title" class="text-base font-semibold text-gray-900">Daftar Petugas</h2>
        <p class="text-sm text-gray-600">Menampilkan <?= (int)count($items) ?> dari total <?= (int)$total ?> data</p>
      </div>
      <?php if (($pages ?? 1) > 1): ?>
      <div class="hidden sm:flex items-center gap-2">
        <?php
          $prev = max(1, (int)$page - 1);
          $next = min((int)$pages, (int)$page + 1);
          $base = '/petugas' . ($q !== '' ? ('?q=' . rawurlencode($q) . '&') : '?');
        ?>
        <a class="btn btn-secondary <?= $page <= 1 ? 'opacity-50 pointer-events-none' : '' ?>" href="<?= $base ?>page=<?= $prev ?>">Sebelumnya</a>
        <span class="text-sm text-gray-600">Halaman <?= (int)$page ?> / <?= (int)$pages ?></span>
        <a class="btn btn-secondary <?= $page >= $pages ? 'opacity-50 pointer-events-none' : '' ?>" href="<?= $base ?>page=<?= $next ?>">Berikutnya</a>
      </div>
      <?php endif; ?>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200" role="table" aria-describedby="table-title">
        <thead class="bg-gray-50" role="rowgroup">
          <tr role="row">
            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dibuat</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Diperbarui</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" role="rowgroup">
          <?php if (empty($items)): ?>
            <tr role="row">
              <td colspan="5" class="px-6 py-10 text-center text-gray-600">
                <div class="flex flex-col items-center justify-center gap-2">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-8 h-8 text-gray-400" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.5 7.5l13 9m-13 0l13-9" />
                  </svg>
                  <div class="font-medium">Belum ada data petugas</div>
                  <div class="text-sm">Tambahkan melalui tombol "Tambah Petugas"</div>
                </div>
              </td>
            </tr>
          <?php else: foreach ($items as $index => $row): ?>
            <tr class="<?= $index % 2 === 0 ? 'bg-white' : 'bg-gray-50/50' ?> hover:bg-blue-50/50 transition-colors duration-150" role="row">
              <td class="px-6 py-4" role="cell">
                <div class="font-medium text-gray-900 flex items-center gap-2">
                  <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-blue-100 text-blue-700 text-xs font-semibold" aria-hidden="true">P</span>
                  <?= htmlspecialchars($row['nama']) ?>
                </div>
              </td>
              <td class="px-6 py-4" role="cell">
                <?php $aktif = (int)($row['aktif'] ?? 0) === 1; ?>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium whitespace-nowrap <?= $aktif ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' ?>"
                      aria-label="Status: <?= $aktif ? 'Aktif' : 'Nonaktif' ?>">
                  <?= $aktif ? 'Aktif' : 'Nonaktif' ?>
                </span>
              </td>
              <td class="px-6 py-4 text-sm text-gray-600" role="cell">
                <time datetime="<?= htmlspecialchars($row['created_at']) ?>">
                  <?= htmlspecialchars($row['created_at']) ?>
                </time>
              </td>
              <td class="px-6 py-4 text-sm text-gray-600" role="cell">
                <time datetime="<?= htmlspecialchars($row['updated_at']) ?>">
                  <?= htmlspecialchars($row['updated_at']) ?>
                </time>
              </td>
              <td class="px-6 py-4" role="cell">
                <form method="post" action="/petugas/<?= (int)$row['id'] ?>/hapus" onsubmit="return confirm('Yakin ingin menghapus petugas ini? Tindakan ini tidak dapat dibatalkan.');">
                  <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                  <button type="submit" class="btn btn-danger btn-micro text-xs px-3 py-1.5" aria-label="Hapus petugas <?= htmlspecialchars($row['nama']) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-1.5" aria-hidden="true">
                      <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2h.293l.853 10.234A2 2 0 007.14 18h5.72a2 2 0 001.994-1.766L15.707 6H16a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0010 2H9zM8 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 112 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd" />
                    </svg>
                    Hapus
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>

    <?php if (($pages ?? 1) > 1): ?>
    <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between">
      <div class="text-sm text-gray-600">Halaman <?= (int)$page ?> dari <?= (int)$pages ?></div>
      <div class="flex items-center gap-2">
        <?php
          $prev = max(1, (int)$page - 1);
          $next = min((int)$pages, (int)$page + 1);
          $base = '/petugas' . ($q !== '' ? ('?q=' . rawurlencode($q) . '&') : '?');
        ?>
        <a class="btn btn-secondary <?= $page <= 1 ? 'opacity-50 pointer-events-none' : '' ?>" href="<?= $base ?>page=<?= $prev ?>">Sebelumnya</a>
        <a class="btn btn-secondary <?= $page >= $pages ? 'opacity-50 pointer-events-none' : '' ?>" href="<?= $base ?>page=<?= $next ?>">Berikutnya</a>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div>

<script>
  function clearSearch() {
    const input = document.getElementById('searchInput');
    if (input) { input.value = ''; }
    const btn = document.getElementById('searchBtn');
    if (btn) { btn.click(); }
  }
</script>
