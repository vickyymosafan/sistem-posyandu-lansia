<?php
$errors = $errors ?? [];
$old = $old ?? [];
function err($f,$e){ 
  if (!isset($e[$f])) return '';
  return '<div class="form-error">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 flex-shrink-0 mt-0.5">
      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
    </svg>
    <span>'.htmlspecialchars($e[$f]).'</span>
  </div>';
}
?>
<div class="max-w-2xl">
  <!-- Back Button -->
  <div class="mb-4">
    <a href="/lansia" onclick="haptic(); if (history.length>1) { history.back(); return false; }" class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
      </svg>
      Kembali
    </a>
  </div>
  <div class="mb-6">
    <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-900 mb-2">Pendaftaran Lansia</h1>
    <p class="text-gray-600">Lengkapi formulir di bawah untuk mendaftarkan lansia baru</p>
  </div>
  
  <form class="space-y-6 bg-white border border-gray-200 rounded-xl p-6 shadow-card" method="post" action="/lansia" onsubmit="return validateForm(this)" role="form" aria-labelledby="form-title">
    <div class="form-group">
      <label class="form-label required" for="nama_lengkap">Nama Lengkap</label>
      <input class="form-input <?= isset($errors['nama_lengkap']) ? 'error' : '' ?>" 
             type="text" 
             id="nama_lengkap" 
             name="nama_lengkap" 
             required 
             maxlength="150" 
             placeholder="Masukkan nama lengkap"
             value="<?= htmlspecialchars($old['nama_lengkap'] ?? '') ?>"
             aria-describedby="<?= isset($errors['nama_lengkap']) ? 'nama_lengkap_error' : '' ?>"
             aria-invalid="<?= isset($errors['nama_lengkap']) ? 'true' : 'false' ?>">
      <?php if (isset($errors['nama_lengkap'])): ?>
        <div id="nama_lengkap_error" class="form-error" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 flex-shrink-0 mt-0.5">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
          </svg>
          <span><?= htmlspecialchars($errors['nama_lengkap']) ?></span>
        </div>
      <?php endif; ?>
    </div>
    
    <div class="form-group">
      <label class="form-label required" for="tgl_lahir">Tanggal Lahir</label>
      <input class="form-input <?= isset($errors['tgl_lahir']) ? 'error' : '' ?>" 
             type="date" 
             id="tgl_lahir" 
             name="tgl_lahir" 
             required 
             value="<?= htmlspecialchars($old['tgl_lahir'] ?? '') ?>" 
             oninput="hitungUsiaLive()" 
             onchange="hitungUsiaLive()"
             aria-describedby="usiaLive <?= isset($errors['tgl_lahir']) ? 'tgl_lahir_error' : '' ?>"
             aria-invalid="<?= isset($errors['tgl_lahir']) ? 'true' : 'false' ?>">
      <div id="usiaLive" class="form-help" aria-live="polite"></div>
      <?php if (isset($errors['tgl_lahir'])): ?>
        <div id="tgl_lahir_error" class="form-error" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 flex-shrink-0 mt-0.5">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
          </svg>
          <span><?= htmlspecialchars($errors['tgl_lahir']) ?></span>
        </div>
      <?php endif; ?>
    </div>
    
    <fieldset class="form-group">
      <legend class="form-label required">Jenis Kelamin</legend>
      <div class="form-group-inline" role="radiogroup" aria-describedby="<?= isset($errors['jk']) ? 'jk_error' : '' ?>" aria-invalid="<?= isset($errors['jk']) ? 'true' : 'false' ?>">
        <label class="inline-flex items-center gap-2 cursor-pointer">
          <input class="form-radio" type="radio" name="jk" value="L" required <?= (($old['jk'] ?? '')==='L')?'checked':''; ?> aria-describedby="jk-help">
          <span class="text-sm text-gray-700">Laki-laki</span>
        </label>
        <label class="inline-flex items-center gap-2 cursor-pointer">
          <input class="form-radio" type="radio" name="jk" value="P" required <?= (($old['jk'] ?? '')==='P')?'checked':''; ?> aria-describedby="jk-help">
          <span class="text-sm text-gray-700">Perempuan</span>
        </label>
      </div>
      <div id="jk-help" class="sr-only">Pilih jenis kelamin lansia</div>
      <?php if (isset($errors['jk'])): ?>
        <div id="jk_error" class="form-error" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 flex-shrink-0 mt-0.5">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
          </svg>
          <span><?= htmlspecialchars($errors['jk']) ?></span>
        </div>
      <?php endif; ?>
    </fieldset>
    
    <div class="form-group">
      <label class="form-label required" for="alamat">Alamat Lengkap</label>
      <textarea class="form-textarea <?= isset($errors['alamat']) ? 'error' : '' ?>" 
                id="alamat" 
                name="alamat" 
                required 
                rows="3"
                placeholder="Masukkan alamat lengkap"
                aria-describedby="<?= isset($errors['alamat']) ? 'alamat_error' : '' ?>"
                aria-invalid="<?= isset($errors['alamat']) ? 'true' : 'false' ?>"><?= htmlspecialchars($old['alamat'] ?? '') ?></textarea>
      <?php if (isset($errors['alamat'])): ?>
        <div id="alamat_error" class="form-error" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 flex-shrink-0 mt-0.5">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
          </svg>
          <span><?= htmlspecialchars($errors['alamat']) ?></span>
        </div>
      <?php endif; ?>
    </div>
    
    <div class="form-group">
      <label class="form-label required" for="no_telp">Nomor Telepon</label>
      <input class="form-input <?= isset($errors['no_telp']) ? 'error' : '' ?>" 
             type="tel" 
             id="no_telp" 
             name="no_telp" 
             required 
             placeholder="08xxxxxxxxxx" 
             value="<?= htmlspecialchars($old['no_telp'] ?? '') ?>"
             aria-describedby="no_telp_help <?= isset($errors['no_telp']) ? 'no_telp_error' : '' ?>"
             aria-invalid="<?= isset($errors['no_telp']) ? 'true' : 'false' ?>">
      <div id="no_telp_help" class="form-help">Format Indonesia, contoh: 08xxxxxxxxxx atau +628xxxxxxxxxx</div>
      <?php if (isset($errors['no_telp'])): ?>
        <div id="no_telp_error" class="form-error" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 flex-shrink-0 mt-0.5">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
          </svg>
          <span><?= htmlspecialchars($errors['no_telp']) ?></span>
        </div>
      <?php endif; ?>
    </div>
    
    <div class="pt-4 border-t border-gray-200">
      <button class="btn btn-primary btn-micro w-full" type="submit" onclick="haptic()" aria-describedby="submit-help">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2" aria-hidden="true">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L8.23 10.661a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
        </svg>
        Daftarkan Lansia
      </button>
      <div id="submit-help" class="sr-only">Tekan untuk menyimpan data pendaftaran lansia</div>
    </div>
  </form>
</div>

<script>
function validateForm(form){
  const tel = form.no_telp.value.trim();
  const re = /^(?:\+62|62|0)8[1-9][0-9]{7,10}$/;
  if(!re.test(tel)){
    // Show user-friendly error message with enhanced animation
    const telInput = form.no_telp;
    window.loadingManager.setInputError(telInput);
    telInput.focus();
    
    // Create or update error message
    let errorEl = telInput.parentNode.querySelector('.form-error');
    if (!errorEl) {
      errorEl = document.createElement('div');
      errorEl.className = 'form-error animate-fade-in';
      errorEl.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 flex-shrink-0 mt-0.5">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
        </svg>
        <span>Format nomor telepon tidak valid. Gunakan format Indonesia yang benar.</span>
      `;
      telInput.parentNode.appendChild(errorEl);
    }
    
    // Remove error styling after user starts typing
    telInput.addEventListener('input', function() {
      this.classList.remove('error', 'form-input-error');
      const err = this.parentNode.querySelector('.form-error');
      if (err) {
        err.style.opacity = '0';
        setTimeout(() => err.remove(), 150);
      }
    }, { once: true });
    
    // Enhanced haptic feedback for error
    haptic(20);
    return false;
  }
  
  // Show enhanced loading state
  const btn = form.querySelector('button[type="submit"]');
  if(btn){ 
    window.loadingManager.setButtonLoading(btn, 'Menyimpan Data...');
    
    // Show form loading overlay for better UX
    window.loadingManager.showFormLoading(form, 'Menyimpan data lansia...');
  }
  return true;
}

// Hitung usia otomatis dari input tanggal lahir
function hitungUsiaLive(){
  const el = document.getElementById('tgl_lahir');
  const out = document.getElementById('usiaLive');
  if(!el || !out) return;
  const val = el.value;
  if(!val){ out.textContent = ''; return; }
  const dob = new Date(val + 'T00:00:00');
  if(isNaN(dob.getTime())){ out.textContent=''; return; }
  const now = new Date();
  let y = now.getFullYear() - dob.getFullYear();
  let m = now.getMonth() - dob.getMonth();
  let d = now.getDate() - dob.getDate();
  if (d < 0) { m -= 1; }
  if (m < 0) { y -= 1; m += 12; }
  const parts = [];
  if (y > 0) parts.push(y + ' tahun');
  if (m > 0) parts.push(m + ' bulan');
  if (parts.length === 0) parts.push('0 bulan');
  out.textContent = 'Usia: ' + parts.join(' ');
}
document.addEventListener('DOMContentLoaded', function() {
  hitungUsiaLive();
  
  // Enhanced keyboard navigation for form
  const formElements = document.querySelectorAll('input, textarea, button, select');
  
  formElements.forEach((element, index) => {
    element.addEventListener('keydown', function(e) {
      // Enhanced Enter key handling
      if (e.key === 'Enter' && !e.shiftKey) {
        if (element.type === 'submit') {
          return; // Let submit button work normally
        }
        
        if (element.tagName === 'TEXTAREA') {
          return; // Let textarea handle Enter normally
        }
        
        // Move to next form element
        e.preventDefault();
        const nextIndex = index + 1;
        if (nextIndex < formElements.length) {
          formElements[nextIndex].focus();
        }
      }
      
      // Escape key to clear current field (for inputs)
      if (e.key === 'Escape' && (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA')) {
        element.value = '';
        element.dispatchEvent(new Event('input', { bubbles: true }));
      }
    });
    
    // Enhanced focus management
    element.addEventListener('focus', function() {
      // Announce field to screen readers
      if (element.labels && element.labels.length > 0) {
        const label = element.labels[0].textContent;
        announceToScreenReader(`Fokus pada ${label}`);
      }
    });
  });
  
  // Form validation announcements
  const form = document.querySelector('form');
  if (form) {
    form.addEventListener('submit', function(e) {
      const errors = form.querySelectorAll('.form-error[role="alert"]');
      if (errors.length > 0) {
        announceToScreenReader(`Formulir memiliki ${errors.length} kesalahan yang perlu diperbaiki`);
      }
    });
  }
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
