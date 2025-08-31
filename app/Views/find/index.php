<!-- Modern Search Container with Enhanced Design -->
<div class="max-w-lg mx-auto">
  <!-- Back Button -->
  <div class="mb-4">
    <a href="/" onclick="haptic(); if (history.length>1) { history.back(); return false; }" class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
      </svg>
      Kembali
    </a>
  </div>
  <!-- Header Section with Better Typography -->
  <div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-blue-600">
        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd" />
      </svg>
    </div>
    <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-900 mb-3">Cari ID Unik</h1>
    <p class="text-gray-600 text-base leading-relaxed">Masukkan ID Unik untuk mengakses profil lansia dengan cepat dan mudah</p>
  </div>
  
  <!-- Enhanced Search Form -->
  <form method="post" action="/find" class="bg-white border border-gray-200 rounded-2xl p-8 shadow-card hover:shadow-card-hover transition-all duration-200" onsubmit="return handleSearchSubmit(this)" role="search" aria-labelledby="search-title">
    <div class="form-group">
      <label class="form-label required text-base font-semibold" for="kode" id="search-title">ID Unik Lansia</label>
      
      <!-- Enhanced Input with Better Visual Feedback -->
      <div class="relative group">
        <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-150" aria-hidden="true">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd" />
          </svg>
        </span>
        <input class="form-input pl-12 pr-4 py-4 font-mono text-lg tracking-wide <?= !empty($error) ? 'error' : '' ?>" 
               type="text" 
               id="kode" 
               name="kode" 
               placeholder="Contoh: ABC123XYZ" 
               required 
               autocomplete="off"
               spellcheck="false"
               value="<?= htmlspecialchars(($old['kode'] ?? '')) ?>"
               oninput="handleInputChange(this)"
               aria-describedby="kode-help <?= !empty($error) ? 'kode-error' : '' ?>"
               aria-invalid="<?= !empty($error) ? 'true' : 'false' ?>">
        
        <!-- Clear Button -->
        <button type="button" 
                class="absolute right-3 top-1/2 -translate-y-1/2 p-1 rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-all duration-150 opacity-0 group-focus-within:opacity-100" 
                onclick="clearInput()"
                id="clearBtn"
                aria-label="Hapus input pencarian"
                tabindex="-1">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4" aria-hidden="true">
            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
          </svg>
        </button>
      </div>
      
      <!-- Enhanced Error Display -->
      <?php if (!empty($error)): ?>
        <div id="kode-error" class="form-error mt-3 animate-fade-in" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 flex-shrink-0 mt-0.5" aria-hidden="true">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
          </svg>
          <span><?= htmlspecialchars($error) ?></span>
        </div>
      <?php endif; ?>
      
      <!-- Enhanced Help Text -->
      <div id="kode-help" class="form-help flex items-start gap-2 mt-3">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" aria-hidden="true">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.94 6.94a.75.75 0 11-1.061-1.061 3 3 0 112.871 5.026v.345a.75.75 0 01-1.5 0v-.5c0-.72.57-1.172 1.081-1.287A1.5 1.5 0 108.94 6.94zM10 15a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
        </svg>
        <span>ID Unik terdiri dari kombinasi huruf dan angka yang diberikan saat pendaftaran</span>
      </div>
    </div>
    
    <!-- Enhanced Submit Button -->
    <button class="btn btn-primary btn-micro w-full mt-6 py-4 text-base font-semibold" type="submit" id="searchBtn" aria-describedby="search-button-help">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2" aria-hidden="true">
        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
      </svg>
      <span>Buka Profil Lansia</span>
    </button>
    <div id="search-button-help" class="sr-only">Tekan untuk mencari dan membuka profil lansia berdasarkan ID Unik</div>
  </form>
  
  <!-- Additional Help Section -->
  <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
    <div class="flex items-start gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
      </svg>
      <div>
        <h3 class="text-sm font-semibold text-blue-900 mb-1">Tidak ingat ID Unik?</h3>
        <p class="text-sm text-blue-700 leading-relaxed">Hubungi petugas posyandu atau cek kartu identitas lansia untuk mendapatkan ID Unik yang tepat.</p>
      </div>
    </div>
  </div>
</div>

<script>
function handleSearchSubmit(form) {
  haptic();
  
  // Show enhanced loading state with better UX
  const btn = form.querySelector('#searchBtn');
  if(btn){ 
    window.loadingManager.setButtonLoading(btn, 'Mencari Data...');
    window.loadingManager.showFormLoading(form, 'Mencari profil lansia...');
  }
  
  return true;
}

function handleInputChange(input) {
  const clearBtn = document.getElementById('clearBtn');
  if (clearBtn) {
    clearBtn.style.opacity = input.value.length > 0 ? '1' : '0';
  }
  
  // Remove error styling when user starts typing
  if (input.classList.contains('error')) {
    input.classList.remove('error');
    const errorDiv = input.closest('.form-group').querySelector('.form-error');
    if (errorDiv) {
      errorDiv.style.opacity = '0';
      setTimeout(() => errorDiv.remove(), 150);
    }
  }
}

function clearInput() {
  const input = document.getElementById('kode');
  const clearBtn = document.getElementById('clearBtn');
  if (input) {
    input.value = '';
    input.focus();
    haptic(5);
  }
  if (clearBtn) {
    clearBtn.style.opacity = '0';
  }
}

// Enhanced keyboard navigation
document.addEventListener('DOMContentLoaded', function() {
  const input = document.getElementById('kode');
  if (input) {
    // Auto-focus on desktop
    if (window.innerWidth >= 768) {
      input.focus();
    }
    
    // Format input as user types (uppercase)
    input.addEventListener('input', function(e) {
      const cursorPos = e.target.selectionStart;
      e.target.value = e.target.value.toUpperCase();
      e.target.setSelectionRange(cursorPos, cursorPos);
      handleInputChange(e.target);
    });
    
    // Handle Enter key
    input.addEventListener('keydown', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        const form = e.target.closest('form');
        if (form) {
          form.dispatchEvent(new Event('submit', { cancelable: true }));
        }
      }
    });
  }
});
</script>
