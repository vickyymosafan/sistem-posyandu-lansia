<?php
// $items: list lansia, $page, $pages, $total, $q, $perPage
function badgeJK($jk){ return $jk==='L' ? 'Laki-laki' : 'Perempuan'; }
?>
<div class="space-y-4">
  <div class="flex items-center justify-between gap-3 flex-wrap">
    <h1 class="text-xl md:text-2xl font-bold tracking-tight">Daftar Lansia</h1>
    <form method="get" class="flex items-center gap-2 w-full sm:w-auto">
      <div class="relative flex-1 sm:flex-none">
        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M10 2a8 8 0 1 1 5.293 13.707l4 4-1.414 1.414-4-4A8 8 0 0 1 10 2Zm0 2a6 6 0 1 0 0 12 6 6 0 0 0 0-12Z"/></svg>
        </span>
        <input class="w-full border rounded-lg pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="search" name="q" placeholder="Cari nama atau ID" value="<?= htmlspecialchars($q ?? '') ?>">
      </div>
      <button class="bg-blue-600 text-white text-sm px-3 py-2 rounded-lg hover:bg-blue-700 active:scale-[.99]" type="submit" onclick="haptic()">Cari</button>
    </form>
  </div>

  <div class="bg-white/80 backdrop-blur border rounded-xl overflow-x-auto">
    <table class="min-w-full text-sm table-auto">
      <thead class="bg-gray-50/80">
        <tr>
          <th class="text-left px-4 py-3 border-b">Nama Lengkap</th>
          <th class="text-left px-4 py-3 border-b">Tanggal Lahir</th>
          <th class="text-left px-4 py-3 border-b">JK</th>
          <th class="text-left px-4 py-3 border-b">ID Unik</th>
          <th class="text-left px-4 py-3 border-b">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($items)): ?>
          <tr><td class="px-4 py-3" colspan="5">Belum ada data.</td></tr>
        <?php else: foreach ($items as $row): ?>
          <tr class="hover:bg-gray-50/80">
            <td class="px-4 py-2 border-b align-top">
              <div class="font-medium">
                <a class="text-blue-700 hover:underline" href="/lansia/<?= htmlspecialchars($row['id_unik']) ?>"><?= htmlspecialchars($row['nama_lengkap']) ?></a>
              </div>
            </td>
            <td class="px-4 py-2 border-b align-top"><?= htmlspecialchars($row['tgl_lahir']) ?></td>
            <td class="px-4 py-2 border-b align-top"><?= htmlspecialchars(badgeJK($row['jk'])) ?></td>
            <td class="px-4 py-2 border-b align-top"><code><?= htmlspecialchars($row['id_unik']) ?></code></td>
            <td class="px-4 py-2 border-b align-top">
              <a class="inline-flex items-center px-2.5 py-1.5 rounded border text-blue-700 border-blue-200 hover:bg-blue-50" href="/lansia/<?= htmlspecialchars($row['id_unik']) ?>">Lihat</a>
              <a class="inline-flex items-center ml-2 px-2.5 py-1.5 rounded border text-green-700 border-green-200 hover:bg-green-50" href="/lansia/<?= htmlspecialchars($row['id_unik']) ?>/pemeriksaan">Pemeriksaan</a>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>

  <div class="flex items-center justify-between text-sm">
    <div>Total: <?= (int)$total ?> data</div>
    <?php if (($pages ?? 1) > 1): ?>
      <div class="flex items-center gap-2">
        <?php 
          $qParam = $q !== null && $q !== '' ? '&q=' . rawurlencode($q) : '';
          $mk = function($p) use ($qParam){ return '/lansia?page='.(int)$p.$qParam; };
          $prev = max(1, (int)$page - 1); $next = min((int)$pages, (int)$page + 1);
        ?>
        <a class="px-2 py-1 border rounded-lg <?= ($page<=1?'pointer-events-none opacity-50':'') ?>" href="<?= $mk($prev) ?>">Sebelumnya</a>
        <span>Hal. <?= (int)$page ?> / <?= (int)$pages ?></span>
        <a class="px-2 py-1 border rounded-lg <?= ($page>=$pages?'pointer-events-none opacity-50':'') ?>" href="<?= $mk($next) ?>">Berikutnya</a>
      </div>
    <?php endif; ?>
  </div>
</div>
