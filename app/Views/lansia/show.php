<?php
// $l: data lansia, $qr_url: url
?>
<div class="grid gap-6 items-start md:grid-cols-[minmax(0,1fr)_420px]">
  <div class="space-y-2">
    <div class="bg-white/80 backdrop-blur border rounded-xl p-4">
      <h2 class="font-semibold mb-3">Data Lansia</h2>
      <?php
        try {
          $dob = new DateTime($l['tgl_lahir']);
          $diff = $dob->diff(new DateTime());
          $usiaText = $diff->y . ' tahun' . ($diff->m>0 ? ' ' . $diff->m . ' bulan' : '');
        } catch (Throwable $e) { $usiaText = null; }
      ?>
      <div class="text-sm">
        <div class="grid grid-cols-[110px_auto_1fr] sm:grid-cols-[140px_auto_1fr] gap-x-2 py-1.5 border-t first:border-t-0 border-gray-100 items-baseline">
          <div class="text-gray-600">Nama</div><div>:</div><div class="font-medium"><?= htmlspecialchars($l['nama_lengkap']) ?></div>
        </div>
        <div class="grid grid-cols-[110px_auto_1fr] sm:grid-cols-[140px_auto_1fr] gap-x-2 py-1.5 border-t border-gray-100 items-baseline">
          <div class="text-gray-600">Tanggal Lahir</div><div>:</div><div class="font-medium"><?= htmlspecialchars($l['tgl_lahir']) ?></div>
        </div>
        <div class="grid grid-cols-[110px_auto_1fr] sm:grid-cols-[140px_auto_1fr] gap-x-2 py-1.5 border-t border-gray-100 items-baseline">
          <div class="text-gray-600">Usia</div><div>:</div><div class="font-medium"><?= htmlspecialchars($usiaText ?? '-') ?></div>
        </div>
        <div class="grid grid-cols-[110px_auto_1fr] sm:grid-cols-[140px_auto_1fr] gap-x-2 py-1.5 border-t border-gray-100 items-baseline">
          <div class="text-gray-600">Jenis Kelamin</div><div>:</div><div class="font-medium"><?= $l['jk']==='L'?'Laki-laki':'Perempuan' ?></div>
        </div>
        <div class="grid grid-cols-[110px_auto_1fr] sm:grid-cols-[140px_auto_1fr] gap-x-2 py-1.5 border-t border-gray-100 items-baseline">
          <div class="text-gray-600">Alamat</div><div>:</div><div class="font-medium whitespace-pre-line"><?= htmlspecialchars($l['alamat']) ?></div>
        </div>
        <div class="grid grid-cols-[110px_auto_1fr] sm:grid-cols-[140px_auto_1fr] gap-x-2 py-1.5 border-t border-gray-100 items-baseline">
          <div class="text-gray-600">No. Telepon</div><div>:</div><div class="font-medium"><?= htmlspecialchars($l['no_telp']) ?></div>
        </div>
      </div>
      <div class="pt-4">
        <a href="/lansia/<?= htmlspecialchars($l['id_unik']) ?>/pemeriksaan" class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 active:scale-[.99]" onclick="haptic()">Mulai Pemeriksaan Baru</a>
      </div>
    </div>
  </div>
  <div>
    <div class="bg-white/80 backdrop-blur border rounded-xl p-4">
      <h2 class="font-semibold mb-3">ID Unik</h2>
      <div class="grid grid-cols-[110px_auto_1fr] sm:grid-cols-[140px_auto_1fr] gap-y-2 gap-x-2 items-start text-sm">
        <div class="col-span-3 flex items-center gap-2 flex-wrap">
          <div id="unikCode" class="font-mono text-xl md:text-2xl tracking-widest select-all inline-block border rounded-lg px-4 py-2 bg-gray-50 whitespace-nowrap max-w-full overflow-x-auto">
            <?= htmlspecialchars($l['id_unik']) ?>
          </div>
          <button type="button" id="copyUnikBtn" class="shrink-0 inline-flex items-center gap-1 px-3 py-2 rounded-lg border hover:bg-gray-50 text-gray-700" aria-live="polite">
            <svg id="iconCopy" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M8 7a3 3 0 0 1 3-3h7a3 3 0 0 1 3 3v9a3 3 0 0 1-3 3h-7a3 3 0 0 1-3-3V7Zm-4 4a3 3 0 0 1 3-3v8a5 5 0 0 0 5 5h6a3 3 0 0 1-3 2H7a3 3 0 0 1-3-3v-9Z"/></svg>
            <span id="copyUnikText" class="hidden sm:inline">Salin</span>
          </button>
        </div>
        <div class="col-span-3 text-gray-600 mt-1">Gunakan ID ini untuk mencari profil lansia.</div>
      </div>
      <script>
        (function(){
          const btn = document.getElementById('copyUnikBtn');
          const codeEl = document.getElementById('unikCode');
          if(!btn || !codeEl) return;
          btn.addEventListener('click', function(){
            const txt = codeEl.textContent.trim();
            if (navigator.clipboard && txt) {
              navigator.clipboard.writeText(txt).then(()=>{
                const label = document.getElementById('copyUnikText');
                const icon = document.getElementById('iconCopy');
                btn.classList.add('bg-green-50','border-green-200','text-green-700');
                if (label) label.textContent = 'Tersalin';
                if (icon) icon.outerHTML = '<svg id="iconCopy" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M9 12.75 11.25 15 15 9.75l1.5 1.5L11.25 18 7.5 14.25 9 12.75Z"/></svg>';
                setTimeout(()=>{
                  btn.classList.remove('bg-green-50','border-green-200','text-green-700');
                  if (label) label.textContent = 'Salin';
                  if (icon) icon.outerHTML = '<svg id="iconCopy" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M8 7a3 3 0 0 1 3-3h7a3 3 0 0 1 3 3v9a3 3 0 0 1-3 3h-7a3 3 0 0 1-3-3V7Zm-4 4a3 3 0 0 1 3-3v8a5 5 0 0 0 5 5h6a3 3 0 0 1-3 2H7a3 3 0 0 1-3-3v-9Z"/></svg>';
                }, 1200);
                haptic();
              }).catch(()=>{});
            }
          });
        })();
      </script>
    </div>
  </div>
</div>
