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
  <div class="grid gap-8 items-start lg:grid-cols-1">
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
            <!-- ID Unik inline -->
            <div class="mt-3 flex flex-wrap items-center gap-3">
              <span class="text-sm text-gray-600">ID Unik:</span>
              <span id="unikCodeInline" class="font-mono text-base font-semibold tracking-wider text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-200 select-all">
                <?= htmlspecialchars($l['id_unik']) ?>
              </span>
              <button type="button" id="copyUnikBtnInline" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-semibold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 16.5V6.75A2.25 2.25 0 0110.25 4.5h6a2.25 2.25 0 012.25 2.25v9.75A2.25 2.25 0 0116.25 18.75h-6A2.25 2.25 0 018 16.5z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7.5H6.75A2.25 2.25 0 004.5 9.75v9.75A2.25 2.25 0 006.75 21.75h9.75A2.25 2.25 0 0018.75 19.5V18"/>
                </svg>
                <span>Salin</span>
              </button>
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
              <div class="text-base font-semibold text-gray-900 leading-relaxed">
                <?php $tel = trim((string)($l['no_telp'] ?? '')); ?>
                <?php if ($tel): ?>
                  <a href="tel:<?= htmlspecialchars(preg_replace('/\s+/', '', $tel)) ?>" class="text-blue-700 hover:text-blue-800 hover:underline">
                    <?= htmlspecialchars($tel) ?>
                  </a>
                <?php else: ?>
                  <span class="text-gray-500">-</span>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- Identity Information -->
          <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
            <div class="flex items-center gap-3 mb-4">
              <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-white">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75a2.25 2.25 0 012.25 2.25v12a2.25 2.25 0 01-2.25 2.25h-9A2.25 2.25 0 015.25 18V6A2.25 2.25 0 017.5 3.75h9zM8.25 8.25h7.5M8.25 12h7.5M8.25 15.75h4.5" />
                </svg>
              </div>
              <h3 class="text-lg font-semibold text-gray-900 leading-tight">Identitas Kependudukan</h3>
            </div>
            <div class="grid grid-cols-1 gap-4">
              <div>
                <div class="text-sm font-medium text-gray-600 mb-1.5 leading-relaxed">NIK</div>
                <div class="text-base font-semibold text-gray-900 leading-relaxed font-mono tracking-wider">
                  <?= htmlspecialchars($l['nik'] ?? '-') ?>
                </div>
              </div>
              <div>
                <div class="text-sm font-medium text-gray-600 mb-1.5 leading-relaxed">No. KK</div>
                <div class="text-base font-semibold text-gray-900 leading-relaxed font-mono tracking-wider">
                  <?= htmlspecialchars($l['kk'] ?? '-') ?>
                </div>
              </div>
            </div>
          </div>
          <!-- Address Information -->
          <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
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
      </div>
      
      <!-- Riwayat Pemeriksaan + Ringkasan Tren -->
      <!-- Stack vertically to avoid clipping; remove 2-column grid layout -->
      <div class="space-y-6">
        <!-- Riwayat (kiri) -->
        <div id="riwayat" class="bg-white border border-gray-200 rounded-xl p-8 shadow-sm">
          <h2 class="text-xl font-semibold text-gray-900 mb-6 leading-tight">Riwayat Pemeriksaan</h2>
          <?php if (empty($riwayat ?? [])): ?>
            <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600">Belum ada riwayat pemeriksaan.</div>
          <?php else: ?>
            <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full table-modern text-sm">
              <thead>
                <tr class="text-left text-xs uppercase tracking-wide text-gray-500">
                  <th class="py-3 pr-4">Tanggal</th>
                  <th class="py-3 px-4 text-right">TD (mmHg)</th>
                  <th class="py-3 px-4 text-right">BMI</th>
                  <th class="py-3 px-4 text-right">Gula</th>
                  <th class="py-3 px-4 text-right">Kolesterol Total</th>
                  <th class="py-3 pl-4 text-right">Asam Urat</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                <?php 
                  $expGula = function($tipe){
                    $t = strtolower(trim((string)$tipe));
                    if ($t === 'puasa') return 'Pemeriksaan setelah puasa ≥ 8 jam';
                    if ($t === 'sewaktu') return 'Pemeriksaan sewaktu/acak tanpa persiapan';
                    if ($t === '2jpp' || $t === '2hpp' || $t === 'pp2' || $t === '2jampp') return 'Pemeriksaan 2 jam setelah makan (postprandial)';
                    return null;
                  };
                ?>
                <?php foreach(($riwayat ?? []) as $i => $row): ?>
                  <tr class="align-top odd:bg-white even:bg-gray-50 hover:bg-gray-50">
                    <td class="py-4 pr-4 text-gray-700">
                      <div class="font-mono text-gray-900">
                        <time datetime="<?= htmlspecialchars($row['tgl_periksa']) ?>">
                          <?= htmlspecialchars((new DateTime($row['tgl_periksa']))->format('d M Y H:i')) ?>
                        </time>
                      </div>
                      <?php if (!empty($row['petugas_nama'])): ?>
                        <div class="mt-1 text-xs text-gray-500">Dicatat oleh: <?= htmlspecialchars($row['petugas_nama']) ?></div>
                      <?php endif; ?>
                    </td>
                    <td class="py-4 px-4 text-right text-gray-900 font-mono">
                      <?php if ($row['sistolik'] && $row['diastolik']): ?>
                        <?= (int)$row['sistolik'] ?>/<?= (int)$row['diastolik'] ?> <span class="text-gray-500">mmHg</span>
                        <?php if ($row['tekanan_darah_kategori']): ?>
                          <span class="block mt-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <?= htmlspecialchars($row['tekanan_darah_kategori']) ?>
                          </span>
                        <?php endif; ?>
                      <?php else: ?>
                        -
                      <?php endif; ?>
                    </td>
                    <td class="py-4 px-4 text-right text-gray-900 font-mono">
                      <?php if ($row['bmi']): ?>
                        <?= htmlspecialchars($row['bmi']) ?>
                        <?php if ($row['bmi_kategori']): ?>
                          <span class="block mt-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            <?= htmlspecialchars($row['bmi_kategori']) ?>
                          </span>
                        <?php endif; ?>
                      <?php else: ?>-
                      <?php endif; ?>
                    </td>
                    <td class="py-4 px-4 text-right text-gray-900 font-mono">
                      <?php if ($row['gula_mgdl']): ?>
                        <?= (int)$row['gula_mgdl'] ?> <span class="text-gray-500">mg/dL</span>
                        <?php $gexp = $expGula($row['gula_tipe'] ?? null); ?>
                        <div class="mt-1">
                          <?php if ($row['gula_kategori']): ?>
                            <div class="text-xs text-gray-600">Kategori: 
                              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                <?= htmlspecialchars($row['gula_kategori']) ?>
                              </span>
                            </div>
                          <?php endif; ?>
                          <?php if ($row['gula_tipe']): ?>
                            <div class="text-[11px] text-gray-500">Tipe: 
                              <span class="font-medium text-amber-700"><?= htmlspecialchars(strtoupper($row['gula_tipe'])) ?></span>
                              <?php if ($gexp): ?> — <?= htmlspecialchars($gexp) ?><?php endif; ?>
                            </div>
                          <?php endif; ?>
                        </div>
                      <?php else: ?>-
                      <?php endif; ?>
                    </td>
                    <td class="py-4 px-4 text-right text-gray-900 font-mono">
                      <?php if ($row['kolesterol_total_mgdl'] !== null && $row['kolesterol_total_mgdl'] !== ''): ?>
                        <?= (int)$row['kolesterol_total_mgdl'] ?> <span class="text-gray-500">mg/dL</span>
                        <?php if ($row['kolesterol_total_kategori']): ?>
                          <span class="block mt-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            <?= htmlspecialchars($row['kolesterol_total_kategori']) ?>
                          </span>
                        <?php endif; ?>
                      <?php else: ?>-
                      <?php endif; ?>
                    </td>
                    <td class="py-4 pl-4 text-right text-gray-900 font-mono">
                      <?php if ($row['asam_urat_mgdl']): ?>
                        <?= htmlspecialchars($row['asam_urat_mgdl']) ?> <span class="text-gray-500">mg/dL</span>
                        <?php if ($row['asam_urat_kategori']): ?>
                          <span class="block mt-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
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
                  <div class="text-sm font-semibold text-gray-900 font-mono">
                    <?= htmlspecialchars((new DateTime($row['tgl_periksa']))->format('d M Y H:i')) ?>
                  </div>
                  <?php if ($row['sistolik'] && $row['diastolik']): ?>
                    <div class="text-right">
                      <div class="text-xs text-gray-700 font-mono">TD: <?= (int)$row['sistolik'] ?>/<?= (int)$row['diastolik'] ?> <span class="text-gray-500">mmHg</span></div>
                      <?php if (!empty($row['tekanan_darah_kategori'])): ?>
                        <span class="inline-flex mt-1 items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-blue-100 text-blue-800 whitespace-nowrap">
                          <?= htmlspecialchars($row['tekanan_darah_kategori']) ?>
                        </span>
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>
                </div>
                <?php if (!empty($row['petugas_nama'])): ?>
                  <div class="mt-1 text-[11px] text-gray-500">Dicatat oleh: <?= htmlspecialchars($row['petugas_nama']) ?></div>
                <?php endif; ?>
                <div class="mt-2 text-xs text-gray-700 grid grid-cols-2 gap-2">
                  <div>
                    BMI: <span class="font-mono text-gray-900"><?= $row['bmi'] ? htmlspecialchars($row['bmi']) : '-' ?></span>
                    <?php if (!empty($row['bmi_kategori'])): ?>
                      <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-purple-100 text-purple-800 whitespace-nowrap">
                        <?= htmlspecialchars($row['bmi_kategori']) ?>
                      </span>
                    <?php endif; ?>
                  </div>
                  <div>
                    Gula: <span class="font-mono text-gray-900"><?= $row['gula_mgdl'] ? (int)$row['gula_mgdl'] . ' mg/dL' : '-' ?></span>
                    <?php if (!empty($row['gula_kategori'])): ?>
                      <div class="mt-1 text-[11px] text-gray-600">Kategori: 
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-100 text-amber-800 whitespace-nowrap">
                          <?= htmlspecialchars($row['gula_kategori']) ?>
                        </span>
                      </div>
                    <?php endif; ?>
                    <?php 
                      $t = strtolower(trim((string)($row['gula_tipe'] ?? '')));
                      $gexp = ($t==='puasa') ? 'Pemeriksaan setelah puasa ≥ 8 jam' : (($t==='sewaktu') ? 'Pemeriksaan sewaktu/acak tanpa persiapan' : (($t==='2jpp'||$t==='2hpp'||$t==='pp2'||$t==='2jampp') ? 'Pemeriksaan 2 jam setelah makan (postprandial)' : null));
                      if ($t): ?>
                        <div class="mt-1 text-[11px] text-gray-500">Tipe: <span class="font-medium text-amber-700"><?= htmlspecialchars(strtoupper($t)) ?></span><?php if($gexp): ?> — <?= htmlspecialchars($gexp) ?><?php endif; ?></div>
                    <?php endif; ?>
                  </div>
                  <div>
                    Kol: <span class="font-mono text-gray-900"><?= ($row['kolesterol_total_mgdl']!==null && $row['kolesterol_total_mgdl']!=='') ? (int)$row['kolesterol_total_mgdl'] . ' mg/dL' : '-' ?></span>
                    <?php if (!empty($row['kolesterol_total_kategori'])): ?>
                      <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-indigo-100 text-indigo-800 whitespace-nowrap">
                        <?= htmlspecialchars($row['kolesterol_total_kategori']) ?>
                      </span>
                    <?php endif; ?>
                  </div>
                  <div>
                    Asam: <span class="font-mono text-gray-900"><?= $row['asam_urat_mgdl'] ? htmlspecialchars($row['asam_urat_mgdl']) . ' mg/dL' : '-' ?></span>
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

        <!-- Ringkasan Tren (kanan) -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 lg:p-8 shadow-sm">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-lg bg-blue-600 text-white flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-5 h-5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l4 4L17 6" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 leading-tight">Ringkasan Tren</h3>
          </div>
          <?php 
            $latest = ($riwayat[0] ?? null);
            $prev   = ($riwayat[1] ?? null);
            $hasTwo = $latest && $prev;
            $cmp = function($a, $b) {
              if ($a === null || $a === '' || $b === null || $b === '') return null;
              if (!is_numeric($a)) $a = (float)$a;
              if (!is_numeric($b)) $b = (float)$b;
              if ($b == $a) return 'tetap';
              return ($b > $a) ? 'naik' : 'turun';
            };
            $arrow = function($status) {
              if ($status === 'naik')   return '<span class="inline-flex items-center gap-1 text-red-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 0l-5 5m5-5l5 5"/></svg>naik</span>';
              if ($status === 'turun')  return '<span class="inline-flex items-center gap-1 text-green-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m0 0l5-5m-5 5l-5-5"/></svg>turun</span>';
              return '<span class="inline-flex items-center gap-1 text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16"/></svg>tetap</span>';
            };
          ?>
          <?php if (!$hasTwo): ?>
            <p class="text-sm text-gray-600">Belum cukup data untuk ringkasan tren. Tambahkan minimal dua pemeriksaan.</p>
          <?php else: ?>
            <?php 
              $num = function($v, int $precision = 1) {
                if ($v === null || $v === '') return null;
                return round((float)$v, $precision);
              };
              $trendBadge = function($pv, $cv, string $unit = '', int $precision = 1) use ($cmp, $arrow, $num) {
                $p = $num($pv, $precision); $c = $num($cv, $precision);
                if ($p === null || $c === null) return '<span class="text-gray-500">n/a</span>';
                $status = $cmp($p, $c);
                $delta = $c - $p; $fmt = ($precision === 0) ? (string)intval(round($delta)) : number_format($delta, $precision, '.', '');
                $sign = ($delta > 0 ? '+' : ($delta < 0 ? '' : '±'));
                return $arrow($status) . ' <span class="text-gray-500">(' . $sign . $fmt . ($unit ? ' ' . $unit : '') . ')</span>';
              };
              $esc = function($s){ return htmlspecialchars((string)$s); };
              // Badge kategori dengan warna sesuai metrik (konsisten dengan tabel)
              $badge = function(string $label, string $color) use ($esc) {
                $map = [
                  'blue'   => 'bg-blue-100 text-blue-800',      // Tekanan darah
                  'purple' => 'bg-purple-100 text-purple-800',  // BMI
                  'amber'  => 'bg-amber-100 text-amber-800',    // Gula
                  'indigo' => 'bg-indigo-100 text-indigo-800',  // Kolesterol total
                  'green'  => 'bg-green-100 text-green-800',    // Asam urat
                  'gray'   => 'bg-gray-100 text-gray-800',
                ];
                $cls = $map[$color] ?? $map['gray'];
                return '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium '.$cls.'">'.$esc($label).'</span>';
              };
              $catChange = function($prevCat, $currCat, string $color = 'gray') use ($badge){
                if (!$prevCat && !$currCat) return '';
                $p = $prevCat ? $badge($prevCat, $color) : '';
                $c = $currCat ? $badge($currCat, $color) : '';
                if ($prevCat && $currCat) {
                  if ($prevCat === $currCat) {
                    return '<div class="text-xs text-gray-600">Kategori: '.$c.' <span class="ml-1 text-gray-500">(tetap)</span></div>';
                  }
                  return '<div class="text-xs text-gray-600">Kategori: '.$p.' <span class="mx-1 text-gray-400">→</span> '.$c.'</div>';
                }
                return '<div class="text-xs text-gray-600">Kategori: '.($c ?: $p).'</div>';
              };

              // Fokus kategori: tampilkan jelas prev → curr sebagai badge
              $catCell = function($prevCat, $currCat, string $color = 'gray') use ($badge) {
                if (!$prevCat && !$currCat) return '<span class="text-gray-400">-</span>';
                $p = $prevCat ? $badge($prevCat, $color) : '<span class="text-gray-400">-</span>';
                $c = $currCat ? $badge($currCat, $color) : '<span class="text-gray-400">-</span>';
                if ($prevCat && $currCat) {
                  if ($prevCat === $currCat) {
                    return '<div class="flex items-center gap-2">'.$c.'<span class="text-xs text-gray-500">(tetap)</span></div>';
                  }
                  return '<div class="flex items-center gap-2">'.$p.'<span class="text-gray-400">→</span>'.$c.'</div>';
                }
                return '<div class="flex items-center gap-2">'.$p.'<span class="text-gray-400">→</span>'.$c.'</div>';
              };

              // Versi ringkas untuk nilai perubahan (tanpa simbol aneh saat 0)
              $trendBadge2 = function($pv, $cv, string $unit = '', int $precision = 1) use ($cmp, $arrow) {
                $toNum = function($v, int $precision = 1) {
                  if ($v === null || $v === '') return null;
                  return round((float)$v, $precision);
                };
                $p = $toNum($pv, $precision); $c = $toNum($cv, $precision);
                if ($p === null || $c === null) return '<span class="text-gray-500">n/a</span>';
                $status = $cmp($p, $c);
                $delta = $c - $p;
                $fmt = ($precision === 0) ? (string)intval(round($delta)) : number_format($delta, $precision, '.', '');
                $sign = ($delta > 0 ? '+' : ($delta < 0 ? '' : ''));
                return $arrow($status) . ' <span class="text-gray-500">(' . $sign . $fmt . ($unit ? ' ' . $unit : '') . ')</span>';
              };
            ?>
            <div class="space-y-6 text-sm hidden">
              <!-- TD split: Sistolik & Diastolik -->
              <div class="space-y-2">
                <div class="flex items-center justify-between">
                  <div class="text-gray-700 font-medium">TD (mmHg) — Sistolik</div>
                  <div class="text-right text-gray-900">
                    <div class="font-mono">Sebelumnya: <?= ($prev['sistolik'] ?? null) ? intval($prev['sistolik']).' mmHg' : '-' ?></div>
                    <div class="font-mono">Terbaru: <?= ($latest['sistolik'] ?? null) ? intval($latest['sistolik']).' mmHg' : '-' ?></div>
                    <div class="mt-1"><?= $trendBadge($prev['sistolik'] ?? null, $latest['sistolik'] ?? null, 'mmHg', 0) ?></div>
                  </div>
                </div>
                <div class="flex items-center justify-between">
                  <div class="text-gray-700 font-medium">TD (mmHg) — Diastolik</div>
                  <div class="text-right text-gray-900">
                    <div class="font-mono">Sebelumnya: <?= ($prev['diastolik'] ?? null) ? intval($prev['diastolik']).' mmHg' : '-' ?></div>
                    <div class="font-mono">Terbaru: <?= ($latest['diastolik'] ?? null) ? intval($latest['diastolik']).' mmHg' : '-' ?></div>
                    <div class="mt-1"><?= $trendBadge($prev['diastolik'] ?? null, $latest['diastolik'] ?? null, 'mmHg', 0) ?></div>
                  </div>
                </div>
                <?= $catChange($prev['tekanan_darah_kategori'] ?? null, $latest['tekanan_darah_kategori'] ?? null, 'blue') ?>
              </div>

              <!-- BMI -->
              <div class="flex items-start justify-between gap-3">
                <div class="text-gray-700 font-medium">BMI</div>
                <div class="text-right text-gray-900">
                  <div class="font-mono">Sebelumnya: <?= ($prev['bmi'] ?? null) !== null ? $esc($prev['bmi']) : '-' ?></div>
                  <div class="font-mono">Terbaru: <?= ($latest['bmi'] ?? null) !== null ? $esc($latest['bmi']) : '-' ?></div>
                  <div class="mt-1"><?= $trendBadge($prev['bmi'] ?? null, $latest['bmi'] ?? null, '', 1) ?></div>
                  <?= $catChange($prev['bmi_kategori'] ?? null, $latest['bmi_kategori'] ?? null, 'purple') ?>
                </div>
              </div>

              <!-- Gula -->
              <div class="flex items-start justify-between gap-3">
                <div class="text-gray-700 font-medium">Gula</div>
                <div class="text-right text-gray-900">
                  <div class="font-mono">Sebelumnya: <?= ($prev['gula_mgdl'] ?? null) !== null ? (intval($prev['gula_mgdl']).' mg/dL') : '-' ?></div>
                  <div class="font-mono">Terbaru: <?= ($latest['gula_mgdl'] ?? null) !== null ? (intval($latest['gula_mgdl']).' mg/dL') : '-' ?></div>
                  <div class="mt-1"><?= $trendBadge($prev['gula_mgdl'] ?? null, $latest['gula_mgdl'] ?? null, 'mg/dL', 0) ?></div>
                  <?= $catChange($prev['gula_kategori'] ?? null, $latest['gula_kategori'] ?? null, 'amber') ?>
                </div>
              </div>

              <!-- Kolesterol Total -->
              <div class="flex items-start justify-between gap-3">
                <div class="text-gray-700 font-medium">Kolesterol Total</div>
                <div class="text-right text-gray-900">
                  <div class="font-mono">Sebelumnya: <?= ($prev['kolesterol_total_mgdl'] ?? null) !== null && $prev['kolesterol_total_mgdl'] !== '' ? (intval($prev['kolesterol_total_mgdl']).' mg/dL') : '-' ?></div>
                  <div class="font-mono">Terbaru: <?= ($latest['kolesterol_total_mgdl'] ?? null) !== null && $latest['kolesterol_total_mgdl'] !== '' ? (intval($latest['kolesterol_total_mgdl']).' mg/dL') : '-' ?></div>
                  <div class="mt-1"><?= $trendBadge($prev['kolesterol_total_mgdl'] ?? null, $latest['kolesterol_total_mgdl'] ?? null, 'mg/dL', 0) ?></div>
                  <?= $catChange($prev['kolesterol_total_kategori'] ?? null, $latest['kolesterol_total_kategori'] ?? null, 'indigo') ?>
                </div>
              </div>

              <!-- Asam Urat -->
              <div class="flex items-start justify-between gap-3">
                <div class="text-gray-700 font-medium">Asam Urat</div>
                <div class="text-right text-gray-900">
                  <div class="font-mono">Sebelumnya: <?= ($prev['asam_urat_mgdl'] ?? null) !== null ? ($esc($prev['asam_urat_mgdl']).' mg/dL') : '-' ?></div>
                  <div class="font-mono">Terbaru: <?= ($latest['asam_urat_mgdl'] ?? null) !== null ? ($esc($latest['asam_urat_mgdl']).' mg/dL') : '-' ?></div>
                  <div class="mt-1"><?= $trendBadge($prev['asam_urat_mgdl'] ?? null, $latest['asam_urat_mgdl'] ?? null, 'mg/dL', 1) ?></div>
                  <?= $catChange($prev['asam_urat_kategori'] ?? null, $latest['asam_urat_kategori'] ?? null, 'green') ?>
                </div>
              </div>
            </div>
            <div class="overflow-x-auto rounded-xl border border-gray-200 p-4">
              <table class="min-w-full table-auto text-sm md:text-base">
                <thead class="bg-gray-50">
                  <tr class="text-left text-xs uppercase tracking-wide text-gray-500">
                    <th class="py-3 pr-6 font-semibold">Metrik</th>
                    <th class="py-3 px-6 text-right font-semibold">Sebelumnya</th>
                    <th class="py-3 px-6 text-right font-semibold">Terbaru</th>
                    <th class="py-3 px-6 font-semibold">Perubahan</th>
                    <th class="py-3 pl-6 w-60 font-semibold text-left">Kategori</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                  <tr class="hover:bg-gray-50 align-middle">
                    <td class="py-3 pr-6 text-gray-700 font-medium">TD Sistolik (mmHg)</td>
                    <td class="py-3 px-6 font-mono text-right text-gray-900 whitespace-nowrap"><?= ($prev['sistolik'] ?? null) ? intval($prev['sistolik']).' mmHg' : '-' ?></td>
                    <td class="py-3 px-6 font-mono text-right text-gray-900 whitespace-nowrap"><?= ($latest['sistolik'] ?? null) ? intval($latest['sistolik']).' mmHg' : '-' ?></td>
                    <td class="py-3 px-6 text-gray-900 whitespace-nowrap"><?= $trendBadge2($prev['sistolik'] ?? null, $latest['sistolik'] ?? null, 'mmHg', 0) ?></td>
                    <td class="py-3 pl-6 text-left"></td>
                  </tr>
                  <tr class="hover:bg-gray-50 align-middle">
                    <td class="py-3 pr-6 text-gray-700 font-medium">TD Diastolik (mmHg)</td>
                    <td class="py-3 px-6 font-mono text-right text-gray-900 whitespace-nowrap"><?= ($prev['diastolik'] ?? null) ? intval($prev['diastolik']).' mmHg' : '-' ?></td>
                    <td class="py-3 px-6 font-mono text-right text-gray-900 whitespace-nowrap"><?= ($latest['diastolik'] ?? null) ? intval($latest['diastolik']).' mmHg' : '-' ?></td>
                    <td class="py-3 px-6 text-gray-900 whitespace-nowrap"><?= $trendBadge2($prev['diastolik'] ?? null, $latest['diastolik'] ?? null, 'mmHg', 0) ?></td>
                    <td class="py-3 pl-6 text-left"></td>
                  </tr>
                  <tr class="hover:bg-gray-50 align-middle">
                    <td class="py-3 pr-6 text-gray-700 font-medium">TD (Kategori)</td>
                    <td class="py-3 px-6"></td>
                    <td class="py-3 px-6"></td>
                    <td class="py-3 px-6"></td>
                    <td class="py-3 pl-6 text-left whitespace-nowrap"><div class="min-w-[220px]"><?= $catCell($prev['tekanan_darah_kategori'] ?? null, $latest['tekanan_darah_kategori'] ?? null, 'blue') ?></div></td>
                  </tr>
                  <tr class="hover:bg-gray-50 align-middle">
                    <td class="py-3 pr-6 text-gray-700 font-medium">BMI</td>
                    <td class="py-3 px-6 font-mono text-right text-gray-900 whitespace-nowrap"><?= ($prev['bmi'] ?? null) !== null ? htmlspecialchars((string)$prev['bmi']) : '-' ?></td>
                    <td class="py-3 px-6 font-mono text-right text-gray-900 whitespace-nowrap"><?= ($latest['bmi'] ?? null) !== null ? htmlspecialchars((string)$latest['bmi']) : '-' ?></td>
                    <td class="py-3 px-6 text-gray-900 whitespace-nowrap"><?= $trendBadge2($prev['bmi'] ?? null, $latest['bmi'] ?? null, '', 1) ?></td>
                    <td class="py-3 pl-6 text-left whitespace-nowrap"><div class="min-w-[220px]"><?= $catCell($prev['bmi_kategori'] ?? null, $latest['bmi_kategori'] ?? null, 'purple') ?></div></td>
                  </tr>
                  <tr class="hover:bg-gray-50 align-middle">
                    <td class="py-3 pr-6 text-gray-700 font-medium">Gula (mg/dL)</td>
                    <td class="py-3 px-6 font-mono text-right text-gray-900 whitespace-nowrap"><?= ($prev['gula_mgdl'] ?? null) !== null ? (intval($prev['gula_mgdl']).' mg/dL') : '-' ?></td>
                    <td class="py-3 px-6 font-mono text-right text-gray-900 whitespace-nowrap"><?= ($latest['gula_mgdl'] ?? null) !== null ? (intval($latest['gula_mgdl']).' mg/dL') : '-' ?></td>
                    <td class="py-3 px-6 text-gray-900 whitespace-nowrap"><?= $trendBadge2($prev['gula_mgdl'] ?? null, $latest['gula_mgdl'] ?? null, 'mg/dL', 0) ?></td>
                    <td class="py-3 pl-6 text-left whitespace-nowrap"><div class="min-w-[220px]"><?= $catCell($prev['gula_kategori'] ?? null, $latest['gula_kategori'] ?? null, 'amber') ?></div></td>
                  </tr>
                  <tr class="hover:bg-gray-50 align-middle">
                    <td class="py-3 pr-6 text-gray-700 font-medium">Kolesterol Total (mg/dL)</td>
                    <td class="py-3 px-6 font-mono text-right text-gray-900 whitespace-nowrap"><?= ($prev['kolesterol_total_mgdl'] ?? null) !== null && $prev['kolesterol_total_mgdl'] !== '' ? (intval($prev['kolesterol_total_mgdl']).' mg/dL') : '-' ?></td>
                    <td class="py-3 px-6 font-mono text-right text-gray-900 whitespace-nowrap"><?= ($latest['kolesterol_total_mgdl'] ?? null) !== null && $latest['kolesterol_total_mgdl'] !== '' ? (intval($latest['kolesterol_total_mgdl']).' mg/dL') : '-' ?></td>
                    <td class="py-3 px-6 text-gray-900 whitespace-nowrap"><?= $trendBadge2($prev['kolesterol_total_mgdl'] ?? null, $latest['kolesterol_total_mgdl'] ?? null, 'mg/dL', 0) ?></td>
                    <td class="py-3 pl-6 text-left whitespace-nowrap"><div class="min-w-[220px]"><?= $catCell($prev['kolesterol_total_kategori'] ?? null, $latest['kolesterol_total_kategori'] ?? null, 'indigo') ?></div></td>
                  </tr>
                  <tr class="hover:bg-gray-50 align-middle">
                    <td class="py-3 pr-6 text-gray-700 font-medium">Asam Urat (mg/dL)</td>
                    <td class="py-3 px-6 font-mono text-right text-gray-900 whitespace-nowrap"><?= ($prev['asam_urat_mgdl'] ?? null) !== null ? (htmlspecialchars((string)$prev['asam_urat_mgdl']).' mg/dL') : '-' ?></td>
                    <td class="py-3 px-6 font-mono text-right text-gray-900 whitespace-nowrap"><?= ($latest['asam_urat_mgdl'] ?? null) !== null ? (htmlspecialchars((string)$latest['asam_urat_mgdl']).' mg/dL') : '-' ?></td>
                    <td class="py-3 px-6 text-gray-900 whitespace-nowrap"><?= $trendBadge2($prev['asam_urat_mgdl'] ?? null, $latest['asam_urat_mgdl'] ?? null, 'mg/dL', 1) ?></td>
                    <td class="py-3 pl-6 text-left whitespace-nowrap"><div class="min-w-[220px]"><?= $catCell($prev['asam_urat_kategori'] ?? null, $latest['asam_urat_kategori'] ?? null, 'green') ?></div></td>
                  </tr>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </div>
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
    
  </div>
</div>
<script>
  (function(){
    const btn = document.getElementById('copyUnikBtnInline');
    const codeEl = document.getElementById('unikCodeInline');
    if(!btn || !codeEl) return;
    btn.addEventListener('click', function(){
      const txt = codeEl.textContent.trim();
      if (navigator.clipboard && txt) {
        navigator.clipboard.writeText(txt).then(()=>{
          if (window.loadingManager && window.loadingManager.setButtonSuccess) {
            window.loadingManager.setButtonSuccess(btn, 'Tersalin!', 1500);
          }
          try { if (typeof haptic === 'function') haptic(10); } catch(e) {}
        }).catch(()=>{
          if (window.loadingManager && window.loadingManager.setButtonError) {
            window.loadingManager.setButtonError(btn, 'Gagal Salin', 2000);
          }
          try { if (typeof haptic === 'function') haptic(20); } catch(e) {}
        });
      }
    });
  })();
</script>
