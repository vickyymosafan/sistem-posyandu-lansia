<?php
// $items: list lansia, $page, $pages, $total, $q, $perPage
function badgeJK($jk){ return $jk==='L' ? 'Laki-laki' : 'Perempuan'; }
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
      <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-900">Daftar Lansia</h1>
      <p class="text-gray-600 mt-1">Kelola data lansia yang terdaftar</p>
    </div>
    
    <!-- Enhanced Search Form with Modern Design -->
    <form method="get" class="flex items-center gap-3 w-full sm:w-auto" onsubmit="return handleListSearchSubmit(this)" role="search" aria-label="Pencarian data lansia">
      <!-- On mobile: make input compact and button expansive -->
      <div class="relative flex-1 min-w-0 sm:flex-none sm:min-w-[320px] group">
        <label for="searchInput" class="sr-only">Cari data lansia</label>
        <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-150" aria-hidden="true">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
          </svg>
        </span>
        <input class="form-input pl-10 pr-12 text-sm py-3 bg-white border-gray-300 hover:border-gray-400 focus:border-blue-500 focus:ring-blue-500 transition-all duration-150" 
               type="search" 
               name="q" 
               id="searchInput"
               placeholder="Cari nama lengkap atau ID unik..." 
               autocomplete="off"
               value="<?= htmlspecialchars($q ?? '') ?>"
               oninput="handleSearchInputChange(this)"
               aria-describedby="search-help"
               role="searchbox"
               aria-label="Masukkan nama lengkap atau ID unik untuk mencari data lansia">
        
        <!-- Clear Search Button -->
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
        
        <div id="search-help" class="sr-only">Gunakan kotak pencarian untuk mencari data lansia berdasarkan nama lengkap atau ID unik</div>
        
        <!-- Search Loading Indicator -->
        <div class="absolute right-3 top-1/2 -translate-y-1/2 hidden" id="searchLoading">
          <svg class="animate-spin h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
        </div>
      </div>
      
      <button class="btn btn-primary btn-micro text-sm px-5 py-3 font-medium shadow-sm hover:shadow-md transition-all duration-150 flex-none" 
              type="submit" 
              id="searchBtn"
              onclick="haptic()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
          <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
        </svg>
        <span class="hidden sm:inline">Cari Data</span>
        <span class="sm:hidden">Cari</span>
      </button>
    </form>
  </div>

  <!-- Modern Table Container with responsive behavior -->
  <div class="bg-white border border-gray-200 rounded-xl shadow-card overflow-hidden" role="region" aria-labelledby="table-title">
    <div id="table-title" class="sr-only">Tabel daftar lansia terdaftar</div>
    
    <!-- Desktop Table View -->
    <div class="hidden md:block overflow-x-auto">
      <table class="min-w-full" role="table" aria-label="Daftar data lansia">
        <thead class="bg-gray-50 border-b border-gray-200">
          <tr role="row">
            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-900" scope="col">Nama Lengkap</th>
            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-900" scope="col">Tanggal Lahir</th>
            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-900" scope="col">Jenis Kelamin</th>
            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-900" scope="col">ID Unik</th>
            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-900" scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php if (empty($items)): ?>
            <tr role="row">
              <td class="px-6 py-12 text-center text-gray-500" colspan="5" role="cell">
                <div class="flex flex-col items-center gap-4">
                  <?php if (!empty($q)): ?>
                    <!-- Search No Results State -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16 text-gray-300">
                      <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-center">
                      <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada hasil ditemukan</h3>
                      <p class="text-sm text-gray-600 mb-4">Tidak ada data lansia yang cocok dengan pencarian "<span class="font-medium"><?= htmlspecialchars($q) ?></span>"</p>
                      <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="/lansia" class="btn btn-outline text-sm px-4 py-2">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                            <path fill-rule="evenodd" d="M7.793 2.232a.75.75 0 01-.025 1.06L3.622 7.25h10.003a5.375 5.375 0 010 10.75H10.75a.75.75 0 010-1.5h2.875a3.875 3.875 0 000-7.75H3.622l4.146 3.957a.75.75 0 01-1.036 1.085l-5.5-5.25a.75.75 0 010-1.085l5.5-5.25a.75.75 0 011.06.025z" clip-rule="evenodd" />
                          </svg>
                          Lihat Semua Data
                        </a>
                        <a href="/lansia/create" class="btn btn-primary text-sm px-4 py-2">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                          </svg>
                          Daftarkan Lansia Baru
                        </a>
                      </div>
                    </div>
                  <?php else: ?>
                    <!-- Empty State -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16 text-gray-300">
                      <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437.695z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-center">
                      <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada data lansia</h3>
                      <p class="text-sm text-gray-600 mb-4">Mulai dengan mendaftarkan lansia pertama untuk memulai pengelolaan data.</p>
                      <a href="/lansia/create" class="btn btn-primary text-sm px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                          <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                        </svg>
                        Daftarkan Lansia Pertama
                      </a>
                    </div>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php else: foreach ($items as $index => $row): ?>
            <tr class="<?= $index % 2 === 0 ? 'bg-white' : 'bg-gray-50/50' ?> hover:bg-blue-50/50 transition-colors duration-150" role="row">
              <td class="px-6 py-4" role="cell">
                <div class="font-medium text-gray-900">
                  <a class="text-blue-600 hover:text-blue-800 hover:underline transition-colors duration-150" 
                     href="/lansia/<?= htmlspecialchars($row['id_unik']) ?>"
                     aria-label="Lihat profil <?= htmlspecialchars($row['nama_lengkap']) ?>">
                    <?= htmlspecialchars($row['nama_lengkap']) ?>
                  </a>
                </div>
              </td>
              <td class="px-6 py-4 text-sm text-gray-600" role="cell">
                <time datetime="<?= htmlspecialchars($row['tgl_lahir']) ?>">
                  <?= htmlspecialchars($row['tgl_lahir']) ?>
                </time>
              </td>
              <td class="px-6 py-4" role="cell">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium whitespace-nowrap flex-shrink-0 <?= $row['jk'] === 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' ?>"
                      aria-label="Jenis kelamin: <?= htmlspecialchars($row['jk'] === 'L' ? 'Laki-laki' : 'Perempuan') ?>">
                  <?= htmlspecialchars($row['jk'] === 'L' ? 'Laki-laki' : 'Perempuan') ?>
                </span>
              </td>
              <td class="px-6 py-4" role="cell">
                <code class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-sm font-mono"
                      aria-label="ID Unik: <?= htmlspecialchars($row['id_unik']) ?>">
                  <?= htmlspecialchars($row['id_unik']) ?>
                </code>
              </td>
              <td class="px-6 py-4" role="cell">
                <div class="flex items-center gap-2" role="group" aria-label="Aksi untuk <?= htmlspecialchars($row['nama_lengkap']) ?>">
                  <a class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors duration-150 shadow-sm" 
                     href="/lansia/<?= htmlspecialchars($row['id_unik']) ?>"
                     aria-label="Lihat profil lengkap <?= htmlspecialchars($row['nama_lengkap']) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 mr-1.5" aria-hidden="true">
                      <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                      <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.147.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>
                    Lihat
                  </a>
                  <a class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-green-600 text-white hover:bg-green-700 transition-colors duration-150 shadow-sm" 
                     href="/lansia/<?= htmlspecialchars($row['id_unik']) ?>/pemeriksaan"
                     aria-label="Lakukan pemeriksaan kesehatan untuk <?= htmlspecialchars($row['nama_lengkap']) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 mr-1.5" aria-hidden="true">
                      <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm2.25 8.5a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 3a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
                    </svg>
                    Periksa
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden">
      <?php if (empty($items)): ?>
        <div class="px-6 py-12 text-center text-gray-500">
          <div class="flex flex-col items-center gap-4">
            <?php if (!empty($q)): ?>
              <!-- Mobile Search No Results State -->
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16 text-gray-300">
                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd" />
              </svg>
              <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada hasil ditemukan</h3>
                <p class="text-sm text-gray-600 mb-4">Tidak ada data lansia yang cocok dengan pencarian "<span class="font-medium"><?= htmlspecialchars($q) ?></span>"</p>
                <div class="flex flex-col gap-3">
                  <a href="/lansia" class="btn btn-outline text-sm px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                      <path fill-rule="evenodd" d="M7.793 2.232a.75.75 0 01-.025 1.06L3.622 7.25h10.003a5.375 5.375 0 010 10.75H10.75a.75.75 0 010-1.5h2.875a3.875 3.875 0 000-7.75H3.622l4.146 3.957a.75.75 0 01-1.036 1.085l-5.5-5.25a.75.75 0 010-1.085l5.5-5.25a.75.75 0 011.06.025z" clip-rule="evenodd" />
                    </svg>
                    Lihat Semua Data
                  </a>
                  <a href="/lansia/create" class="btn btn-primary text-sm px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                      <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Daftarkan Lansia Baru
                  </a>
                </div>
              </div>
            <?php else: ?>
              <!-- Mobile Empty State -->
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16 text-gray-300">
                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437.695z" clip-rule="evenodd" />
              </svg>
              <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada data lansia</h3>
                <p class="text-sm text-gray-600 mb-4">Mulai dengan mendaftarkan lansia pertama untuk memulai pengelolaan data.</p>
                <a href="/lansia/create" class="btn btn-primary text-sm px-4 py-2">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                  </svg>
                  Daftarkan Lansia Pertama
                </a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php else: foreach ($items as $index => $row): ?>
        <div class="<?= $index > 0 ? 'border-t border-gray-200' : '' ?> p-4 hover:bg-gray-50/50 transition-colors duration-150">
          <div class="space-y-3">
            <!-- Name and ID -->
            <div class="flex items-start justify-between gap-3">
              <div class="flex-1 min-w-0">
                <h3 class="font-medium text-gray-900 truncate">
                  <a class="text-blue-600 hover:text-blue-800 hover:underline transition-colors duration-150" 
                     href="/lansia/<?= htmlspecialchars($row['id_unik']) ?>">
                    <?= htmlspecialchars($row['nama_lengkap']) ?>
                  </a>
                </h3>
                <p class="text-sm text-gray-500 mt-1">
                  <code class="px-1.5 py-0.5 bg-gray-100 text-gray-800 rounded text-xs font-mono">
                    <?= htmlspecialchars($row['id_unik']) ?>
                  </code>
                </p>
              </div>
              <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium whitespace-nowrap flex-shrink-0 <?= $row['jk'] === 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' ?>">
                <?= htmlspecialchars($row['jk'] === 'L' ? 'Laki-laki' : 'Perempuan') ?>
              </span>
            </div>

            <!-- Birth Date -->
            <div class="text-sm text-gray-600">
              <span class="font-medium">Tanggal Lahir:</span> <?= htmlspecialchars($row['tgl_lahir']) ?>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2 pt-2">
              <a class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors duration-150 shadow-sm" 
                 href="/lansia/<?= htmlspecialchars($row['id_unik']) ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                  <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                  <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.147.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
                Lihat Profil
              </a>
              <a class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium rounded-lg bg-green-600 text-white hover:bg-green-700 transition-colors duration-150 shadow-sm" 
                 href="/lansia/<?= htmlspecialchars($row['id_unik']) ?>/pemeriksaan">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                  <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm2.25 8.5a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 3a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5z" clip-rule="evenodd" />
                </svg>
                Pemeriksaan
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; endif; ?>
    </div>
  </div>

  <!-- Enhanced Search Results Summary -->
  <?php if (!empty($q)): ?>
  <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
    <div class="flex items-center gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-blue-600 flex-shrink-0">
        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
      </svg>
      <div class="flex-1">
        <p class="text-sm font-medium text-blue-900">
          <?php if ((int)$total > 0): ?>
            Ditemukan <?= (int)$total ?> hasil untuk pencarian "<span class="font-semibold"><?= htmlspecialchars($q) ?></span>"
          <?php else: ?>
            Tidak ada hasil untuk pencarian "<span class="font-semibold"><?= htmlspecialchars($q) ?></span>"
          <?php endif; ?>
        </p>
        <?php if ((int)$total === 0): ?>
        <p class="text-xs text-blue-700 mt-1">Coba gunakan kata kunci yang berbeda atau periksa ejaan pencarian Anda.</p>
        <?php endif; ?>
      </div>
      <a href="/lansia" class="text-sm text-blue-600 hover:text-blue-800 font-medium hover:underline transition-colors duration-150">
        Hapus Filter
      </a>
    </div>
  </div>
  <?php endif; ?>

  <div class="flex items-center justify-between text-sm">
    <div class="flex items-center gap-2">
      <span class="text-gray-600">Total:</span>
      <span class="font-semibold text-gray-900"><?= (int)$total ?> data</span>
      <?php if (!empty($q)): ?>
        <span class="text-gray-400">•</span>
        <span class="text-gray-600">dari pencarian</span>
      <?php endif; ?>
    </div>
    <?php if (($pages ?? 1) > 1): ?>
      <div class="flex items-center gap-2">
        <?php 
          $qParam = $q !== null && $q !== '' ? '&q=' . rawurlencode($q) : '';
          $mk = function($p) use ($qParam){ return '/lansia?page='.(int)$p.$qParam; };
          $prev = max(1, (int)$page - 1); $next = min((int)$pages, (int)$page + 1);
        ?>
        <a class="btn btn-outline text-sm px-3 py-2 <?= ($page<=1?'pointer-events-none opacity-50':'') ?>" href="<?= $mk($prev) ?>">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-1">
            <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
          </svg>
          Sebelumnya
        </a>
        <span class="px-3 py-2 text-sm font-medium text-gray-700">Hal. <?= (int)$page ?> / <?= (int)$pages ?></span>
        <a class="btn btn-outline text-sm px-3 py-2 <?= ($page>=$pages?'pointer-events-none opacity-50':'') ?>" href="<?= $mk($next) ?>">
          Berikutnya
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 ml-1">
            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
          </svg>
        </a>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>
function handleListSearchSubmit(form) {
  haptic();
  
  // Show enhanced loading state
  const btn = form.querySelector('#searchBtn');
  if (btn) {
    window.loadingManager.setButtonLoading(btn, 'Mencari...');
  }
  
  return true;
}

function handleSearchInputChange(input) {
  // Show/hide clear button based on input value
  const form = input.closest('form');
  const clearBtn = form.querySelector('button[onclick="clearSearch()"]');
  
  if (clearBtn) {
    if (input.value.length > 0) {
      clearBtn.style.display = 'block';
    } else {
      clearBtn.style.display = 'none';
    }
  }
}

function clearSearch() {
  haptic(5);
  const input = document.getElementById('searchInput');
  if (input) {
    input.value = '';
    input.focus();
    
    // Submit form to clear search
    const form = input.closest('form');
    if (form) {
      // Remove the search parameter and submit
      window.location.href = '/lansia';
    }
  }
}

// Enhanced search functionality with accessibility
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  
  if (searchInput) {
    // Auto-focus search on desktop when there's no existing search
    if (window.innerWidth >= 768 && !searchInput.value) {
      // Small delay to ensure page is fully loaded
      setTimeout(() => {
        if (document.activeElement === document.body) {
          searchInput.focus();
        }
      }, 100);
    }
    
    // Enhanced keyboard shortcuts
    document.addEventListener('keydown', function(e) {
      // Ctrl/Cmd + K to focus search
      if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        searchInput.focus();
        searchInput.select();
        haptic(5);
        announceToScreenReader('Fokus pada kotak pencarian');
      }
      
      // Escape to clear search focus or clear search
      if (e.key === 'Escape') {
        if (document.activeElement === searchInput) {
          if (searchInput.value) {
            clearSearch();
          } else {
            searchInput.blur();
          }
        }
      }
      
      // F3 or Ctrl+F to focus search (alternative shortcuts)
      if (e.key === 'F3' || ((e.ctrlKey || e.metaKey) && e.key === 'f' && e.target.tagName !== 'INPUT')) {
        e.preventDefault();
        searchInput.focus();
        searchInput.select();
      }
    });
    
    // Enhanced input handling with accessibility announcements
    let searchTimeout;
    searchInput.addEventListener('input', function(e) {
      clearTimeout(searchTimeout);
      handleSearchInputChange(e.target);
      
      // Announce search results count after typing stops
      searchTimeout = setTimeout(() => {
        const resultCount = document.querySelectorAll('tbody tr[role="row"]').length;
        if (e.target.value.length > 2) {
          announceToScreenReader(`Menampilkan ${resultCount} hasil pencarian`);
        }
      }, 1000);
    });
    
    // Enhanced focus management
    searchInput.addEventListener('focus', function() {
      announceToScreenReader('Kotak pencarian aktif. Ketik untuk mencari data lansia.');
    });
  }
  
  // Add keyboard shortcut hint for desktop users
  if (window.innerWidth >= 768) {
    const searchInput = document.getElementById('searchInput');
    if (searchInput && !searchInput.value) {
      const originalPlaceholder = searchInput.placeholder;
      searchInput.placeholder = originalPlaceholder + ' (Ctrl+K)';
    }
  }
  
  // Enhanced table keyboard navigation
  const tableRows = document.querySelectorAll('tbody tr[role="row"]');
  tableRows.forEach((row, index) => {
    const links = row.querySelectorAll('a');
    
    links.forEach(link => {
      link.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowDown') {
          e.preventDefault();
          const nextRow = tableRows[index + 1];
          if (nextRow) {
            const nextLink = nextRow.querySelector('a');
            if (nextLink) nextLink.focus();
          }
        }
        
        if (e.key === 'ArrowUp') {
          e.preventDefault();
          const prevRow = tableRows[index - 1];
          if (prevRow) {
            const prevLink = prevRow.querySelector('a');
            if (prevLink) prevLink.focus();
          } else {
            // Focus search input if at top
            searchInput?.focus();
          }
        }
      });
    });
  });
});

// Screen reader announcement function
function announceToScreenReader(message) {
  const announcement = document.createElement('div');
  announcement.setAttribute('aria-live', 'polite');
  announcement.setAttribute('aria-atomic', 'true');
  announcement.className = 'sr-only';
  announcement.textContent = message;
  document.body.appendChild(announcement);
  
  setTimeout(() => {
    if (document.body.contains(announcement)) {
      document.body.removeChild(announcement);
    }
  }, 1000);
}
</script>
