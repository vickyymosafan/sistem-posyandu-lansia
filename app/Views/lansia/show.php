<?php
// $l: data lansia, $qr_url: url
// Calculate age first to avoid undefined variable error
try {
  $dob = new DateTime($l['tgl_lahir']);
  $diff = $dob->diff(new DateTime());
  $usiaText = $diff->y . ' tahun' . ($diff->m>0 ? ' ' . $diff->m . ' bulan' : '');
} catch (Throwable $e) { 
  $usiaText = null; 
}
?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <div class="grid gap-8 items-start lg:grid-cols-[minmax(0,2fr)_minmax(0,1fr)]">
    <div class="space-y-8">
      <!-- Profile Header Card -->
      <div class="bg-white border border-gray-200 rounded-xl p-8 shadow-sm hover:shadow-md transition-shadow duration-200">
        <div class="flex items-center gap-6 mb-8">
          <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10 text-white">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
          </div>
          <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-900 mb-2 leading-tight"><?= htmlspecialchars($l['nama_lengkap']) ?></h1>
            <div class="flex flex-wrap items-center gap-3">
              <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium whitespace-nowrap flex-shrink-0 <?= $l['jk'] === 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' ?>">
                <?= $l['jk']==='L'?'Laki-laki':'Perempuan' ?>
              </span>
              <?php if($usiaText): ?>
              <span class="text-gray-600 font-medium"><?= htmlspecialchars($usiaText) ?></span>
              <?php endif; ?>
            </div>
          </div>
        </div>
        
        <!-- Personal Information Section -->
        <div class="border-t border-gray-100 pt-8">
          <h2 class="text-xl font-semibold text-gray-900 mb-6 leading-tight">Informasi Personal</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Birth Information -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                  </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 leading-tight">Data Kelahiran</h3>
              </div>
              <div class="space-y-4">
                <div>
                  <div class="text-sm font-medium text-gray-600 mb-1.5 leading-relaxed">Tanggal Lahir</div>
                  <div class="text-base font-semibold text-gray-900 leading-relaxed"><?= htmlspecialchars($l['tgl_lahir']) ?></div>
                </div>
                <div>
                  <div class="text-sm font-medium text-gray-600 mb-1.5 leading-relaxed">Usia Saat Ini</div>
                  <div class="text-base font-semibold text-gray-900 leading-relaxed"><?= htmlspecialchars($usiaText ?? '-') ?></div>
                </div>
              </div>
            </div>
            
            <!-- Contact Information -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                  </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 leading-tight">Kontak</h3>
              </div>
              <div>
                <div class="text-sm font-medium text-gray-600 mb-1.5 leading-relaxed">No. Telepon</div>
                <div class="text-base font-semibold text-gray-900 leading-relaxed"><?= htmlspecialchars($l['no_telp']) ?></div>
              </div>
            </div>
          </div>
          
          <!-- Address Information -->
          <div class="mt-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
            <div class="flex items-center gap-3 mb-4">
              <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
              </div>
              <h3 class="text-lg font-semibold text-gray-900 leading-tight">Alamat Tempat Tinggal</h3>
            </div>
            <div class="text-base font-medium text-gray-900 leading-relaxed whitespace-pre-line"><?= htmlspecialchars($l['alamat']) ?></div>
          </div>
        </div>
      </div>
      
      <!-- Riwayat Pemeriksaan -->
      <div id="riwayat" class="bg-white border border-gray-200 rounded-xl p-8 shadow-sm">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 leading-tight">Riwayat Pemeriksaan</h2>
        <?php if (empty($riwayat ?? [])): ?>
          <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600">Belum ada riwayat pemeriksaan.</div>
        <?php else: ?>
          <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full table-modern">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>TD (mmHg)</th>
                  <th>BMI</th>
                  <th>Gula</th>
                  <th>Kolesterol Total</th>
                  <th>Asam Urat</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach(($riwayat ?? []) as $row): ?>
                  <tr>
                    <td class="text-sm text-gray-700">
                      <time datetime="<?= htmlspecialchars($row['tgl_periksa']) ?>">
                        <?= htmlspecialchars((new DateTime($row['tgl_periksa']))->format('d M Y H:i')) ?>
                      </time>
                    </td>
                    <td class="text-sm text-gray-800">
                      <?php if ($row['sistolik'] && $row['diastolik']): ?>
                        <?= (int)$row['sistolik'] ?>/<?= (int)$row['diastolik'] ?>
                        <?php if ($row['tekanan_darah_kategori']): ?>
                          <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <?= htmlspecialchars($row['tekanan_darah_kategori']) ?>
                          </span>
                        <?php endif; ?>
                      <?php else: ?>
                        -
                      <?php endif; ?>
                    </td>
                    <td class="text-sm text-gray-800">
                      <?php if ($row['bmi']): ?>
                        <?= htmlspecialchars($row['bmi']) ?>
                        <?php if ($row['bmi_kategori']): ?>
                          <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            <?= htmlspecialchars($row['bmi_kategori']) ?>
                          </span>
                        <?php endif; ?>
                      <?php else: ?>-
                      <?php endif; ?>
                    </td>
                    <td class="text-sm text-gray-800">
                      <?php if ($row['gula_mgdl']): ?>
                        <?= (int)$row['gula_mgdl'] ?> mg/dL
                        <?php if ($row['gula_tipe']): ?>
                          <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                            <?= htmlspecialchars(strtoupper($row['gula_tipe'])) ?>
                          </span>
                        <?php endif; ?>
                        <?php if ($row['gula_kategori']): ?>
                          <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                            <?= htmlspecialchars($row['gula_kategori']) ?>
                          </span>
                        <?php endif; ?>
                      <?php else: ?>-
                      <?php endif; ?>
                    </td>
                    <td class="text-sm text-gray-800">
                      <?php if ($row['kolesterol_total_mgdl'] !== null && $row['kolesterol_total_mgdl'] !== ''): ?>
                        <?= (int)$row['kolesterol_total_mgdl'] ?> mg/dL
                        <?php if ($row['kolesterol_total_kategori']): ?>
                          <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            <?= htmlspecialchars($row['kolesterol_total_kategori']) ?>
                          </span>
                        <?php endif; ?>
                      <?php else: ?>-
                      <?php endif; ?>
                    </td>
                    <td class="text-sm text-gray-800">
                      <?php if ($row['asam_urat_mgdl']): ?>
                        <?= htmlspecialchars($row['asam_urat_mgdl']) ?> mg/dL
                        <?php if ($row['asam_urat_kategori']): ?>
                          <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <?= htmlspecialchars($row['asam_urat_kategori']) ?>
                          </span>
                        <?php endif; ?>
                      <?php else: ?>-
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <!-- Mobile list -->
          <div class="md:hidden space-y-3">
            <?php foreach(($riwayat ?? []) as $row): ?>
              <div class="p-4 border border-gray-200 rounded-lg bg-white">
                <div class="flex items-start justify-between gap-2">
                  <div class="text-sm font-semibold text-gray-900">
                    <?= htmlspecialchars((new DateTime($row['tgl_periksa']))->format('d M Y H:i')) ?>
                  </div>
                  <?php if ($row['sistolik'] && $row['diastolik']): ?>
                    <div class="text-right">
                      <div class="text-xs text-gray-700">TD: <?= (int)$row['sistolik'] ?>/<?= (int)$row['diastolik'] ?></div>
                      <?php if (!empty($row['tekanan_darah_kategori'])): ?>
                        <span class="inline-flex mt-1 items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-blue-100 text-blue-800 whitespace-nowrap">
                          <?= htmlspecialchars($row['tekanan_darah_kategori']) ?>
                        </span>
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="mt-2 text-xs text-gray-700 grid grid-cols-2 gap-2">
                  <div>
                    BMI: <?= $row['bmi'] ? htmlspecialchars($row['bmi']) : '-' ?>
                    <?php if (!empty($row['bmi_kategori'])): ?>
                      <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-purple-100 text-purple-800 whitespace-nowrap">
                        <?= htmlspecialchars($row['bmi_kategori']) ?>
                      </span>
                    <?php endif; ?>
                  </div>
                  <div>
                    Gula: <?= $row['gula_mgdl'] ? (int)$row['gula_mgdl'] . ' mg/dL' : '-' ?>
                    <?php if (!empty($row['gula_tipe'])): ?>
                      <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-100 text-amber-800 whitespace-nowrap">
                        <?= htmlspecialchars(strtoupper($row['gula_tipe'])) ?>
                      </span>
                    <?php endif; ?>
                    <?php if (!empty($row['gula_kategori'])): ?>
                      <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-100 text-amber-800 whitespace-nowrap">
                        <?= htmlspecialchars($row['gula_kategori']) ?>
                      </span>
                    <?php endif; ?>
                  </div>
                  <div>
                    Kol: <?= ($row['kolesterol_total_mgdl']!==null && $row['kolesterol_total_mgdl']!=='') ? (int)$row['kolesterol_total_mgdl'] . ' mg/dL' : '-' ?>
                    <?php if (!empty($row['kolesterol_total_kategori'])): ?>
                      <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-indigo-100 text-indigo-800 whitespace-nowrap">
                        <?= htmlspecialchars($row['kolesterol_total_kategori']) ?>
                      </span>
                    <?php endif; ?>
                  </div>
                  <div>
                    Asam: <?= $row['asam_urat_mgdl'] ? htmlspecialchars($row['asam_urat_mgdl']) . ' mg/dL' : '-' ?>
                    <?php if (!empty($row['asam_urat_kategori'])): ?>
                      <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-green-100 text-green-800 whitespace-nowrap">
                        <?= htmlspecialchars($row['asam_urat_kategori']) ?>
                      </span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Action Section -->
      <div class="bg-white border border-gray-200 rounded-xl p-8 shadow-sm">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 leading-tight">Tindakan</h2>
        <div class="flex flex-col sm:flex-row gap-4">
          <a href="/lansia/<?= htmlspecialchars($l['id_unik']) ?>/pemeriksaan" 
             class="inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-colors duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" 
             onclick="haptic()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-3">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c0 .621-.504 1.125-1.125 1.125H18a2.25 2.25 0 01-2.25-2.25V9.375c0-.621.504-1.125 1.125-1.125H20.25a2.25 2.25 0 012.25 2.25v11.25a2.25 2.25 0 01-2.25 2.25H21M8.25 8.25l4.5-4.5" />
            </svg>
            Mulai Pemeriksaan Baru
          </a>
          <a href="/lansia" 
             class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-3">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
            </svg>
            Kembali ke Daftar
          </a>
        </div>
      </div>
    </div>
    <!-- ID Unik Card -->
    <div class="bg-white border border-gray-200 rounded-xl p-8 shadow-sm hover:shadow-md transition-shadow duration-200">
      <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0z" />
          </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900 leading-tight">ID Unik Lansia</h2>
      </div>
      
      <div class="space-y-6">
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6 border border-indigo-200">
          <div class="text-sm font-medium text-indigo-700 mb-3 leading-relaxed">Kode Identifikasi</div>
          <div id="unikCode" class="font-mono text-2xl lg:text-3xl font-bold tracking-wider text-indigo-900 select-all break-all leading-tight">
            <?= htmlspecialchars($l['id_unik']) ?>
          </div>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3">
          <button type="button" id="copyUnikBtn" 
                  class="btn btn-info btn-micro inline-flex items-center justify-center px-4 py-3 text-white font-semibold rounded-xl transition-colors duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 flex-1" 
                  aria-live="polite">
            <svg id="iconCopy" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
            </svg>
            <span id="copyUnikText">Salin ID</span>
          </button>
        </div>
        
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
          <div class="flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
            <div>
              <div class="text-sm font-medium text-amber-800 mb-1 leading-relaxed">Cara Penggunaan</div>
              <div class="text-sm text-amber-700 leading-relaxed">Gunakan ID unik ini untuk mencari dan mengidentifikasi profil lansia dalam sistem.</div>
            </div>
          </div>
        </div>
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
                // Use enhanced success state with better UX
                window.loadingManager.setButtonSuccess(btn, 'Tersalin!', 1500);
                haptic(10);
              }).catch(()=>{
                window.loadingManager.setButtonError(btn, 'Gagal Salin', 2000);
                haptic(20);
              });
            }
          });
        })();
      </script>
    </div>
  </div>
</div>
