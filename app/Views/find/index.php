<div class="max-w-md mx-auto">
  <h1 class="text-xl md:text-2xl font-bold tracking-tight mb-4">Cari ID Unik</h1>
  <form method="post" action="/find" class="space-y-4 bg-white/80 backdrop-blur border rounded-xl p-4" onsubmit="haptic()">
    <div>
      <label class="block text-sm mb-1" for="kode">ID Unik</label>
      <div class="relative">
        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M10 2a8 8 0 1 1 5.293 13.707l4 4-1.414 1.414-4-4A8 8 0 0 1 10 2Zm0 2a6 6 0 1 0 0 12 6 6 0 0 0 0-12Z"/></svg>
        </span>
        <input class="w-full border rounded-lg pl-9 pr-3 py-2 font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="text" id="kode" name="kode" placeholder="Masukkan ID Unik" required value="<?= htmlspecialchars(($old['kode'] ?? '')) ?>">
      </div>
      <?php if (!empty($error)): ?>
        <p class="text-red-600 text-sm mt-1"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>
    </div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 active:scale-[.99]" type="submit">Buka Profil</button>
  </form>
</div>
