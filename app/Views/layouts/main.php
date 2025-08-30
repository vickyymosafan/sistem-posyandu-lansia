<?php /* Main layout */ ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'Aplikasi') ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="data:,">
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">
  <?php
    $curr = strtok($_SERVER['REQUEST_URI'] ?? '/', '?') ?: '/';
    $isActive = function (string $href) use ($curr): bool {
        if ($href === '/') return $curr === '/';
        return $curr === $href || str_starts_with($curr, $href . '/');
    };
    $linkCls = function (bool $active): string {
        $base = 'inline-flex items-center px-3 py-2 rounded-lg transition-colors';
        return $active ? ($base . ' bg-blue-100 text-blue-700') : ($base . ' text-gray-700 hover:text-blue-700 hover:bg-blue-50');
    };
  ?>
  <header class="bg-white/90 backdrop-blur border-b sticky top-0 z-20" id="siteHeader">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
      <a href="/" class="flex items-center gap-2 font-semibold tracking-tight">
        <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 text-white">PL</span>
        <span class="bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600">Posyandu Lansia</span>
      </a>

      <!-- Desktop nav -->
      <nav class="hidden md:flex items-center gap-1 text-sm">
        <a href="/lansia" class="<?= $linkCls($isActive('/lansia')) ?>">Daftar Lansia</a>
        <a href="/lansia/create" class="<?= $linkCls($isActive('/lansia/create')) ?>">Pendaftaran</a>
        <a href="/find" class="<?= $linkCls($isActive('/find')) ?>">Cari ID</a>
      </nav>

      <!-- Mobile toggle -->
      <button id="navToggle" class="md:hidden inline-flex items-center justify-center h-10 w-10 rounded-lg hover:bg-gray-100 text-gray-700" aria-expanded="false" aria-controls="mobileMenu">
        <span class="sr-only">Toggle navigation</span>
        <svg id="iconMenu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
        <svg id="iconClose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6 hidden"><path d="M6.225 4.811 4.81 6.225 10.586 12l-5.775 5.775 1.414 1.414L12 13.414l5.775 5.775 1.414-1.414L13.414 12l5.775-5.775-1.414-1.414L12 10.586 6.225 4.811z"/></svg>
      </button>
    </div>

    <!-- Mobile nav -->
    <div id="mobileMenu" class="md:hidden hidden border-t">
      <nav class="px-4 py-3 grid gap-2 text-sm">
        <a href="/lansia" class="<?= $linkCls($isActive('/lansia')) ?>">Daftar Lansia</a>
        <a href="/lansia/create" class="<?= $linkCls($isActive('/lansia/create')) ?>">Pendaftaran</a>
        <a href="/find" class="<?= $linkCls($isActive('/find')) ?>">Cari ID</a>
      </nav>
    </div>
  </header>

  <main class="max-w-6xl mx-auto px-4 py-6 flex-1">
    <?php include $view_template_path; ?>
  </main>

  <footer class="text-center text-xs text-gray-500 py-6 mt-auto">&copy; <?= date('Y') ?> Posyandu Lansia</footer>

  <script>
    // Haptic feedback helper (if supported)
    function haptic(ms=10){ if (navigator.vibrate) navigator.vibrate(ms); }

    // Mobile nav toggle
    (function(){
      const btn = document.getElementById('navToggle');
      const menu = document.getElementById('mobileMenu');
      const iconMenu = document.getElementById('iconMenu');
      const iconClose = document.getElementById('iconClose');
      if(!btn || !menu) return;
      btn.addEventListener('click', function(){
        const open = menu.classList.contains('hidden') === false;
        if (open) {
          menu.classList.add('hidden');
          btn.setAttribute('aria-expanded', 'false');
          iconMenu.classList.remove('hidden');
          iconClose.classList.add('hidden');
        } else {
          menu.classList.remove('hidden');
          btn.setAttribute('aria-expanded', 'true');
          iconMenu.classList.add('hidden');
          iconClose.classList.remove('hidden');
        }
      });
    })();

    // Add shadow on scroll for subtle depth
    (function(){
      const header = document.getElementById('siteHeader');
      if(!header) return;
      function onScroll(){
        if (window.scrollY > 4) header.classList.add('shadow-sm');
        else header.classList.remove('shadow-sm');
      }
      window.addEventListener('scroll', onScroll, { passive: true });
      onScroll();
    })();
  </script>
</body>
</html>
