<?php
// $l: lansia row
function ferr($e,$f){ 
  if (!isset($e[$f])) return '';
  return '<div class="form-error">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 flex-shrink-0 mt-0.5">
      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
    </svg>
    <span>'.htmlspecialchars($e[$f]).'</span>
  </div>';
}
?>
<div class="space-y-6">
  <!-- Back Button -->
  <div class="flex items-center justify-between">
    <a href="/lansia/<?= htmlspecialchars($l['id_unik']) ?>" 
       class="inline-flex items-center justify-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
       onclick="haptic()">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
      </svg>
      Kembali ke Profil
    </a>
  </div>
  <?php if (!empty($success)): ?>
    <div class="form-success p-4 bg-green-50 border border-green-200 rounded-lg">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 flex-shrink-0 mt-0.5">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L8.23 10.661a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
      </svg>
      <span class="font-medium"><?= htmlspecialchars($success) ?></span>
    </div>
  <?php endif; ?>

  <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-card">
    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2 text-blue-600">
        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
      </svg>
      Data Lansia
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <div class="bg-gray-50 rounded-lg p-3">
        <div class="text-xs text-gray-600 mb-1">Nama Lengkap</div>
        <div class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($l['nama_lengkap']) ?></div>
      </div>
      <div class="bg-gray-50 rounded-lg p-3">
        <div class="text-xs text-gray-600 mb-1">ID Unik</div>
        <div class="font-mono font-semibold text-gray-900 text-sm"><?= htmlspecialchars($l['id_unik']) ?></div>
      </div>
      <div class="bg-gray-50 rounded-lg p-3">
        <div class="text-xs text-gray-600 mb-1">Tanggal Lahir</div>
        <div class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($l['tgl_lahir']) ?></div>
      </div>
      <div class="bg-gray-50 rounded-lg p-3">
        <div class="text-xs text-gray-600 mb-1">Usia</div>
        <div class="font-semibold text-gray-900 text-sm">
          <?php
            try {
              $dob = new DateTime($l['tgl_lahir']);
              $diff = $dob->diff(new DateTime());
              echo htmlspecialchars($diff->y . ' tahun' . ($diff->m>0 ? ' ' . $diff->m . ' bulan' : ''));
            } catch (Throwable $e) { echo '-'; }
          ?>
        </div>
      </div>
      <div class="bg-gray-50 rounded-lg p-3">
        <div class="text-xs text-gray-600 mb-1">Jenis Kelamin</div>
        <div class="font-semibold text-gray-900 text-sm">
          <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $l['jk'] === 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' ?>">
            <?= $l['jk']==='L'?'Laki-laki':'Perempuan' ?>
          </span>
        </div>
      </div>
    </div>
  </div>

  <!-- Responsive Grid Layout for Forms -->
  <form method="post" action="/lansia/<?= htmlspecialchars($l['id_unik']) ?>/pemeriksaan" onsubmit="return valAll(this)">
  <div class="grid lg:grid-cols-2 gap-6">
    <!-- Physical Examination Form -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-card hover:shadow-card-hover transition-shadow duration-200">
      <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2 text-blue-600">
          <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM9 5a1 1 0 112 0v3.5a1 1 0 01-.293.707l-2 2a1 1 0 01-1.414-1.414L9 8.586V5z" clip-rule="evenodd" />
        </svg>
        Pemeriksaan Fisik
      </h2>
      
      <div class="space-y-6">
        <!-- Body Measurements Grid -->
        <div class="grid sm:grid-cols-2 gap-4">
          <div class="form-group">
            <label class="form-label required" for="tinggi_cm">Tinggi Badan</label>
            <div class="relative">
              <input class="form-input pr-12 <?= isset($errors_fisik['tinggi_cm']) ? 'error' : '' ?>" 
                     type="number" 
                     id="tinggi_cm" 
                     name="tinggi_cm" 
                     min="100" 
                     max="200" 
                     required 
                     placeholder="150"
                     value="<?= htmlspecialchars($old_fisik['tinggi_cm'] ?? '') ?>"
                     oninput="validateRealTime(this, 100, 200, 'Tinggi badan'); calcBMI();">
              <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">cm</span>
            </div>
            <?= ferr($errors_fisik ?? [], 'tinggi_cm') ?>
          </div>
          
          <div class="form-group">
            <label class="form-label required" for="berat_kg">Berat Badan</label>
            <div class="relative">
              <input class="form-input pr-12 <?= isset($errors_fisik['berat_kg']) ? 'error' : '' ?>" 
                     type="number" step="1" inputmode="numeric" pattern="\\d*"
                     id="berat_kg" 
                     name="berat_kg" 
                     min="30" 
                     max="150" 
                     required 
                     placeholder="60"
                     value="<?= htmlspecialchars($old_fisik['berat_kg'] ?? '') ?>"
                     oninput="validateIntegerRange(this, 30, 150, 'Berat badan'); calcBMI();">
              <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">kg</span>
            </div>
            <?= ferr($errors_fisik ?? [], 'berat_kg') ?>
          </div>
        </div>
        
        <!-- Blood Pressure Grid -->
        <div class="grid sm:grid-cols-2 gap-4">
          <div class="form-group">
            <label class="form-label required" for="sistolik">Tekanan Sistolik</label>
            <div class="relative">
              <input class="form-input pr-16 <?= isset($errors_fisik['sistolik']) ? 'error' : '' ?>" 
                     type="number" 
                     id="sistolik" 
                     name="sistolik" 
                     min="70" 
                     max="250" 
                     required 
                     placeholder="120"
                     value="<?= htmlspecialchars($old_fisik['sistolik'] ?? '') ?>"
                     oninput="validateRealTime(this, 70, 250, 'Tekanan sistolik'); calcBP();">
              <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-xs font-medium">mmHg</span>
            </div>
            <?= ferr($errors_fisik ?? [], 'sistolik') ?>
          </div>
          
          <div class="form-group">
            <label class="form-label required" for="diastolik">Tekanan Diastolik</label>
            <div class="relative">
              <input class="form-input pr-16 <?= isset($errors_fisik['diastolik']) ? 'error' : '' ?>" 
                     type="number" 
                     id="diastolik" 
                     name="diastolik" 
                     min="40" 
                     max="150" 
                     required 
                     placeholder="80"
                     value="<?= htmlspecialchars($old_fisik['diastolik'] ?? '') ?>"
                     oninput="validateRealTime(this, 40, 150, 'Tekanan diastolik'); calcBP();">
              <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-xs font-medium">mmHg</span>
            </div>
            <?= ferr($errors_fisik ?? [], 'diastolik') ?>
          </div>
        </div>
        
        <!-- Real-time Feedback Display -->
        <div class="space-y-3">
          <div id="bpLive" class="form-help bg-blue-50 border border-blue-200 rounded-lg p-3 hidden">
            <div class="flex items-start gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
              </svg>
              <span class="text-blue-800 font-medium text-sm"></span>
            </div>
          </div>
          <div id="bmiLive" class="form-help bg-green-50 border border-green-200 rounded-lg p-3 hidden">
            <div class="flex items-start gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-green-600 mt-0.5 flex-shrink-0">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
              </svg>
              <span class="text-green-800 font-medium text-sm"></span>
            </div>
          </div>
        </div>
        
      </div>
    </div>

    <!-- Health Examination Form -->
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-card hover:shadow-card-hover transition-shadow duration-200">
      <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2 text-green-600">
          <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
        </svg>
        Pemeriksaan Kesehatan
      </h2>
      
      <div class="space-y-6">
        <!-- Lab Values Grid -->
        <div class="grid sm:grid-cols-2 gap-4">
          <div class="form-group">
            <label class="form-label required" for="asam_urat_mgdl">Asam Urat</label>
            <div class="relative">
              <input class="form-input pr-16 <?= isset($errors_kesehatan['asam_urat_mgdl']) ? 'error' : '' ?>" 
                     type="number" 
                     step="0.1" 
                     id="asam_urat_mgdl" 
                     name="asam_urat_mgdl" 
                     min="2.0" 
                     max="15.0" 
                     required 
                     placeholder="5.5"
                     value="<?= htmlspecialchars($old_kesehatan['asam_urat_mgdl'] ?? '') ?>"
                     oninput="validateRealTime(this, 2.0, 15.0, 'Asam urat'); calcKes();">
              <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-xs font-medium">mg/dL</span>
            </div>
            <?= ferr($errors_kesehatan ?? [], 'asam_urat_mgdl') ?>
          </div>
          
          <div class="form-group">
            <label class="form-label required" for="kolesterol_total_mgdl">Kolesterol Total</label>
            <div class="relative">
              <input class="form-input pr-16 <?= isset($errors_kesehatan['kolesterol_total_mgdl']) ? 'error' : '' ?>" 
                     type="number" 
                     id="kolesterol_total_mgdl" 
                     name="kolesterol_total_mgdl" 
                     min="100" 
                     max="400" 
                     required 
                     placeholder="200"
                     value="<?= htmlspecialchars($old_kesehatan['kolesterol_total_mgdl'] ?? '') ?>"
                     oninput="validateRealTime(this, 100, 400, 'Kolesterol total'); calcKes();">
              <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-xs font-medium">mg/dL</span>
            </div>
            <?= ferr($errors_kesehatan ?? [], 'kolesterol_total_mgdl') ?>
          </div>
        </div>
        
        <!-- Blood Sugar Section -->
        <div class="space-y-4">
          <div class="form-group">
            <label class="form-label required" for="gula_mgdl">Gula Darah</label>
            <div class="relative">
              <input class="form-input pr-16 <?= isset($errors_kesehatan['gula_mgdl']) ? 'error' : '' ?>" 
                     type="number" 
                     id="gula_mgdl" 
                     name="gula_mgdl" 
                     min="50" 
                     max="500" 
                     required 
                     placeholder="100"
                     value="<?= htmlspecialchars($old_kesehatan['gula_mgdl'] ?? '') ?>"
                     oninput="validateRealTime(this, 50, 500, 'Gula darah'); calcKes();">
              <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-xs font-medium">mg/dL</span>
            </div>
            <?= ferr($errors_kesehatan ?? [], 'gula_mgdl') ?>
          </div>
          
          <div class="form-group">
            <label class="form-label required" for="gula_tipe">Tipe Pemeriksaan Gula</label>
            <select class="form-select <?= isset($errors_kesehatan['gula_tipe']) ? 'error' : '' ?>" 
                    id="gula_tipe" 
                    name="gula_tipe" 
                    required
                    onchange="validateSelectRealTime(this); calcKes();">
              <?php $gt = $old_kesehatan['gula_tipe'] ?? ''; ?>
              <option value="" <?= $gt===''?'selected':'' ?>>Pilih tipe pemeriksaan</option>
              <option value="puasa" <?= $gt==='puasa'?'selected':'' ?>>GDP (Gula Darah Puasa)</option>
              <option value="sewaktu" <?= $gt==='sewaktu'?'selected':'' ?>>GDS (Gula Darah Sewaktu)</option>
              <option value="2jpp" <?= $gt==='2jpp'?'selected':'' ?>>2 Jam Setelah Makan</option>
            </select>
            <?= ferr($errors_kesehatan ?? [], 'gula_tipe') ?>
          </div>
        </div>
        
        <!-- Real-time Health Feedback Display -->
        <div id="ketKesLive" class="form-help bg-purple-50 border border-purple-200 rounded-lg p-3 hidden">
          <div class="flex items-start gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-purple-600 mt-0.5 flex-shrink-0">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
            </svg>
            <div class="text-purple-800 font-medium text-sm"></div>
          </div>
        </div>
        
      </div>
    </div>
    <!-- Combined submit button (centered between cards on large screens) -->
    <div class="pt-2 lg:col-span-2 flex justify-center">
      <button id="combinedSubmit" class="btn btn-success btn-micro w-full sm:w-auto px-6" type="submit" onclick="haptic()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
          <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
        </svg>
        Simpan Pemeriksaan
      </button>
    </div>
  </div>
  </form>
</div>


<script>
// Enhanced Real-time Validation Functions
function validateRealTime(input, min, max, label) {
  const value = parseFloat(input.value);
  const isValid = !isNaN(value) && value >= min && value <= max;
  
  // Remove existing error styling and messages
  input.classList.remove('error');
  const existingError = input.parentNode.querySelector('.form-error');
  if (existingError) existingError.remove();
  
  // Add visual feedback for invalid values
  if (input.value && !isValid) {
    input.classList.add('error');
    
    // Create error message
    const errorEl = document.createElement('div');
    errorEl.className = 'form-error animate-fade-in';
    errorEl.innerHTML = `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 flex-shrink-0 mt-0.5">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
      </svg>
      <span>${label} harus antara ${min} - ${max}</span>
    `;
    input.parentNode.appendChild(errorEl);
  }
  
  return isValid;
}

// Validate integer-only inputs within range
function validateIntegerRange(input, min, max, label) {
  const raw = input.value.trim();
  const intPattern = /^\d+$/;
  const isInt = intPattern.test(raw);
  const value = isInt ? parseInt(raw, 10) : NaN;
  const isValid = isInt && value >= min && value <= max;

  // Remove existing error styling and messages
  input.classList.remove('error');
  const existingError = input.parentNode.querySelector('.form-error');
  if (existingError) existingError.remove();

  if (raw && !isValid) {
    input.classList.add('error');
    const errorEl = document.createElement('div');
    errorEl.className = 'form-error animate-fade-in';
    errorEl.innerHTML = `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 flex-shrink-0 mt-0.5">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
      </svg>
      <span>${label} harus bilangan bulat antara ${min} - ${max}</span>
    `;
    input.parentNode.appendChild(errorEl);
  }

  return isValid;
}

function validateSelectRealTime(select) {
  const isValid = select.value !== '';
  
  // Remove existing error styling and messages
  select.classList.remove('error');
  const existingError = select.parentNode.querySelector('.form-error');
  if (existingError) existingError.remove();
  
  if (!isValid) {
    select.classList.add('error');
    
    // Create error message
    const errorEl = document.createElement('div');
    errorEl.className = 'form-error animate-fade-in';
    errorEl.innerHTML = `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 flex-shrink-0 mt-0.5">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
      </svg>
      <span>Pilih tipe pemeriksaan gula darah</span>
    `;
    select.parentNode.appendChild(errorEl);
  }
  
  return isValid;
}

// Enhanced Form Validation Functions
function valFisik(f){
  const toCheck=[
    ['tinggi_cm', 100, 200, 'Tinggi badan'],
    ['berat_kg', 30, 150, 'Berat badan'],
    ['sistolik', 70, 250, 'Tekanan sistolik'],
    ['diastolik', 40, 150, 'Tekanan diastolik']
  ];
  
  let isFormValid = true;
  let firstInvalidField = null;
  
  for(const [id, min, max, label] of toCheck){
    const el = f[id]; 
    const isValid = id === 'berat_kg' ? validateIntegerRange(el, min, max, label) : validateRealTime(el, min, max, label);
    
    if (!isValid) {
      isFormValid = false;
      if (!firstInvalidField) firstInvalidField = el;
      // Add enhanced error feedback
      window.loadingManager.setInputError(el);
    }
  }
  
  if (!isFormValid) {
    firstInvalidField?.focus();
    haptic(20); // Stronger haptic feedback for errors
    return false;
  }
  
  // Show enhanced loading state with form overlay
  const btn = f.querySelector('button[type="submit"]'); 
  if(btn){
    window.loadingManager.setButtonLoading(btn, 'Menyimpan Pemeriksaan...');
    window.loadingManager.showFormLoading(f, 'Memproses data pemeriksaan fisik...');
    
    // Add subtle haptic feedback for successful submission
    haptic(5);
  }
  return true;
}

function valKes(f){
  const required=[
    ['asam_urat_mgdl', 2.0, 15.0, 'Asam urat'],
    ['gula_mgdl', 50, 500, 'Gula darah'],
    ['kolesterol_total_mgdl', 100, 400, 'Kolesterol total']
  ];
  
  let isFormValid = true;
  let firstInvalidField = null;
  
  // Validate select field
  const gulaTipeValid = validateSelectRealTime(f['gula_tipe']);
  if (!gulaTipeValid) {
    isFormValid = false;
    firstInvalidField = f['gula_tipe'];
    window.loadingManager.setInputError(f['gula_tipe']);
  }
  
  // Validate numeric fields
  for(const [id, min, max, label] of required){
    const el = f[id]; 
    const isValid = validateRealTime(el, min, max, label);
    
    if (!isValid) {
      isFormValid = false;
      if (!firstInvalidField) firstInvalidField = el;
      window.loadingManager.setInputError(el);
    }
  }
  
  if (!isFormValid) {
    firstInvalidField?.focus();
    haptic(20); // Stronger haptic feedback for errors
    return false;
  }
  
  // Show enhanced loading state with form overlay
  const btn = f.querySelector('button[type="submit"]'); 
  if(btn){
    window.loadingManager.setButtonLoading(btn, 'Menyimpan Kesehatan...');
    window.loadingManager.showFormLoading(f, 'Memproses data pemeriksaan kesehatan...');
    
    // Add subtle haptic feedback for successful submission
    haptic(5);
  }
  return true;
}

// Validate both sections together before submitting combined form
function valAll(form){
  // Validate Fisik
  const fisikChecks = [
    ['tinggi_cm', 100, 200, 'Tinggi badan'],
    ['berat_kg', 30, 150, 'Berat badan'],
    ['sistolik', 70, 250, 'Tekanan sistolik'],
    ['diastolik', 40, 150, 'Tekanan diastolik']
  ];
  let ok = true; let first = null;
  for (const [id,min,max,label] of fisikChecks){
    const el = form[id];
    const valid = id === 'berat_kg' ? validateIntegerRange(el, min, max, label) : validateRealTime(el, min, max, label);
    if (!valid){ ok=false; if(!first) first=el; window.loadingManager.setInputError(el); }
  }

  // Validate Kesehatan
  const gulaTipeSel = form['gula_tipe'];
  if (!validateSelectRealTime(gulaTipeSel)) { ok=false; if(!first) first=gulaTipeSel; window.loadingManager.setInputError(gulaTipeSel); }
  const kesChecks = [
    ['asam_urat_mgdl', 2.0, 15.0, 'Asam urat'],
    ['gula_mgdl', 50, 500, 'Gula darah'],
    ['kolesterol_total_mgdl', 100, 400, 'Kolesterol total']
  ];
  for (const [id,min,max,label] of kesChecks){
    const el = form[id];
    const valid = validateRealTime(el, min, max, label);
    if (!valid){ ok=false; if(!first) first=el; window.loadingManager.setInputError(el); }
  }

  if (!ok){
    first?.focus();
    haptic(20);
    return false;
  }

  // Loading state
  const btn = document.getElementById('combinedSubmit');
  if (btn){
    window.loadingManager.setButtonLoading(btn, 'Menyimpan Pemeriksaan...');
    window.loadingManager.showFormLoading(form, 'Memproses data pemeriksaan...');
  }
  return true;
}

// Enhanced Real-time Feedback System
const tinggi=document.getElementById('tinggi_cm');
const berat=document.getElementById('berat_kg');
const sistolik=document.getElementById('sistolik');
const diastolik=document.getElementById('diastolik');
const bmiLive=document.getElementById('bmiLive');
const bpLive=document.getElementById('bpLive');

function bmiKategoriLabel(bmi){
  if (bmi < 17.0) return { label: 'Berat Badan Sangat Kurang', color: 'text-red-800', bg: 'bg-red-50', border: 'border-red-200' };
  if (bmi < 18.5) return { label: 'Berat Badan Kurang', color: 'text-orange-800', bg: 'bg-orange-50', border: 'border-orange-200' };
  if (bmi <= 25.0) return { label: 'Berat Badan Normal', color: 'text-green-800', bg: 'bg-green-50', border: 'border-green-200' };
  if (bmi <= 27.0) return { label: 'Kelebihan Berat Badan', color: 'text-yellow-800', bg: 'bg-yellow-50', border: 'border-yellow-200' };
  if (bmi <= 30.0) return { label: 'Obesitas Tingkat I', color: 'text-orange-800', bg: 'bg-orange-50', border: 'border-orange-200' };
  return { label: 'Obesitas Tingkat II', color: 'text-red-800', bg: 'bg-red-50', border: 'border-red-200' };
}

function calcBMI(){
  const t=parseFloat(tinggi?.value||''); 
  const b=parseFloat(berat?.value||'');
  
  if(t && b && t >= 100 && t <= 200 && b >= 30 && b <= 150){
    const bmi=+(b/((t/100)**2)).toFixed(1);
    const kategori=bmiKategoriLabel(bmi);
    
    // Update display with enhanced styling
    bmiLive.className = `form-help ${kategori.bg} border ${kategori.border} rounded-lg p-3`;
    bmiLive.classList.remove('hidden');
    bmiLive.querySelector('span').textContent = `BMI: ${bmi} (${kategori.label})`;
    bmiLive.querySelector('span').className = `${kategori.color} font-medium text-sm`;
  } else {
    bmiLive.classList.add('hidden');
  }
}

function bpKategoriLabel(s, d){
  if (!s || !d) return null;
  const sys = parseInt(s, 10); const dia = parseInt(d, 10);
  
  if (sys>180 || dia>120) return { label: 'Krisis Hipertensi', color: 'text-red-800', bg: 'bg-red-50', border: 'border-red-200' };
  if (sys>=140 || dia>=90) return { label: 'Hipertensi Tahap 2', color: 'text-red-800', bg: 'bg-red-50', border: 'border-red-200' };
  if (sys>=130 || (dia>=80 && dia<=89)) return { label: 'Hipertensi Tahap 1', color: 'text-orange-800', bg: 'bg-orange-50', border: 'border-orange-200' };
  if (sys>=120 && sys<=129 && dia<80) return { label: 'Batas Waspada', color: 'text-yellow-800', bg: 'bg-yellow-50', border: 'border-yellow-200' };
  return { label: 'Normal', color: 'text-green-800', bg: 'bg-green-50', border: 'border-green-200' };
}

function calcBP(){
  const sVal = sistolik?.value || '';
  const dVal = diastolik?.value || '';
  
  if (sVal && dVal && sVal >= 70 && sVal <= 250 && dVal >= 40 && dVal <= 150){
    const kategori = bpKategoriLabel(sVal, dVal);
    if (kategori) {
      // Update display with enhanced styling
      bpLive.className = `form-help ${kategori.bg} border ${kategori.border} rounded-lg p-3`;
      bpLive.classList.remove('hidden');
      bpLive.querySelector('span').textContent = `Tekanan Darah: ${sVal}/${dVal} mmHg (${kategori.label})`;
      bpLive.querySelector('span').className = `${kategori.color} font-medium text-sm`;
    }
  } else {
    bpLive.classList.add('hidden');
  }
}

// Initialize event listeners with debouncing for better performance
let bmiTimeout, bpTimeout;

if(tinggi){ 
  tinggi.addEventListener('input', () => {
    clearTimeout(bmiTimeout);
    bmiTimeout = setTimeout(calcBMI, 300);
  }); 
}
if(berat){ 
  berat.addEventListener('input', () => {
    clearTimeout(bmiTimeout);
    bmiTimeout = setTimeout(calcBMI, 300);
  }); 
}
if(sistolik){ 
  sistolik.addEventListener('input', () => {
    clearTimeout(bpTimeout);
    bpTimeout = setTimeout(calcBP, 300);
  }); 
}
if(diastolik){ 
  diastolik.addEventListener('input', () => {
    clearTimeout(bpTimeout);
    bpTimeout = setTimeout(calcBP, 300);
  }); 
}

// Initial calculations
calcBMI();
calcBP();

// Enhanced Health Examination Real-time Feedback
const jk = <?= json_encode($l['jk'] ?? 'L') ?>; // 'L' atau 'P'
const gulaEl = document.getElementById('gula_mgdl');
const gulaTipeEl = document.getElementById('gula_tipe');
const kolEl = document.getElementById('kolesterol_total_mgdl');
const asamEl = document.getElementById('asam_urat_mgdl');
const ketKesLive = document.getElementById('ketKesLive');

function kelasGula(val, tipe){
  if(!val || !tipe) return null;
  const v = parseInt(val, 10);
  if (tipe === 'puasa') {
    if (v >= 126) return { status: 'DIABETES', color: 'text-red-800' };
    if (v >= 100) return { status: 'PRA_DIABETES', color: 'text-orange-800' };
    return { status: 'NORMAL', color: 'text-green-800' };
  } else if (tipe === '2jpp') {
    if (v >= 200) return { status: 'DIABETES', color: 'text-red-800' };
    if (v >= 140) return { status: 'PRA_DIABETES', color: 'text-orange-800' };
    return { status: 'NORMAL', color: 'text-green-800' };
  } else if (tipe === 'sewaktu') {
    if (v >= 200) return { status: 'DIABETES', color: 'text-red-800' };
    return { status: 'NORMAL', color: 'text-green-800' };
  }
  return null;
}

function kelasKol(val){
  if(!val) return null;
  const v = parseInt(val, 10);
  if (v >= 240) return { status: 'Tinggi', color: 'text-red-800' };
  if (v >= 200) return { status: 'Batas tinggi', color: 'text-orange-800' };
  return { status: 'Normal', color: 'text-green-800' };
}

function kelasAsam(val){
  if(!val) return null;
  const v = parseFloat(val);
  const low = jk === 'L' ? 3.4 : 2.4;
  const high = jk === 'L' ? 7.0 : 6.0;
  if (v < low) return { status: 'Rendah', color: 'text-blue-800' };
  if (v > high) return { status: 'Tinggi', color: 'text-red-800' };
  return { status: 'Normal', color: 'text-green-800' };
}

function labelGulaTipe(t){
  if (t==='puasa') return 'GDP (Puasa)';
  if (t==='sewaktu') return 'GDS (Sewaktu)';
  if (t==='2jpp') return '2 Jam Setelah Makan';
  return t || '-';
}

function calcKes(){
  const gt = gulaTipeEl?.value || '';
  const gv = gulaEl?.value || '';
  const kv = kolEl?.value || '';
  const av = asamEl?.value || '';
  
  // Validate input ranges
  const gulaValid = gv && gv >= 50 && gv <= 500;
  const kolValid = kv && kv >= 100 && kv <= 400;
  const asamValid = av && av >= 2.0 && av <= 15.0;
  
  if (!gulaValid && !kolValid && !asamValid) {
    ketKesLive.classList.add('hidden');
    return;
  }
  
  const gulaK = kelasGula(gv, gt);
  const kolK = kelasKol(kv);
  const asamK = kelasAsam(av);

  let parts = [];
  let hasAbnormal = false;
  
  if (gulaValid && gulaK) {
    let note = '';
    if (gt==='sewaktu' && gulaK.status==='DIABETES') {
      note = ' <span class="text-xs">(Perlu gejala khas untuk diagnosis)</span>';
    }
    parts.push(`<span class="${gulaK.color}">Gula Darah: ${gv} mg/dL (${labelGulaTipe(gt)} → ${gulaK.status})</span>${note}`);
    if (gulaK.status !== 'NORMAL') hasAbnormal = true;
  }
  
  if (kolValid && kolK) {
    parts.push(`<span class="${kolK.color}">Kolesterol: ${kv} mg/dL (${kolK.status})</span>`);
    if (kolK.status !== 'Normal') hasAbnormal = true;
  }
  
  if (asamValid && asamK) {
    parts.push(`<span class="${asamK.color}">Asam Urat: ${av} mg/dL (${asamK.status})</span>`);
    if (asamK.status !== 'Normal') hasAbnormal = true;
  }
  
  if (parts.length > 0) {
    // Update styling based on results
    const bgColor = hasAbnormal ? 'bg-orange-50' : 'bg-purple-50';
    const borderColor = hasAbnormal ? 'border-orange-200' : 'border-purple-200';
    
    ketKesLive.className = `form-help ${bgColor} border ${borderColor} rounded-lg p-3`;
    ketKesLive.classList.remove('hidden');
    ketKesLive.querySelector('div').innerHTML = parts.join('<br>');
  } else {
    ketKesLive.classList.add('hidden');
  }
}

// Initialize event listeners with debouncing for better performance
let kesTimeout;

function debouncedCalcKes() {
  clearTimeout(kesTimeout);
  kesTimeout = setTimeout(calcKes, 300);
}

if (gulaEl) gulaEl.addEventListener('input', debouncedCalcKes);
if (gulaTipeEl) gulaTipeEl.addEventListener('change', calcKes); // Immediate for select
if (kolEl) kolEl.addEventListener('input', debouncedCalcKes);
if (asamEl) asamEl.addEventListener('input', debouncedCalcKes);

// Initial calculation
calcKes();

// Enhanced Form Accessibility and UX Features
document.addEventListener('DOMContentLoaded', function() {
  // Add smooth focus transitions for all form inputs
  const formInputs = document.querySelectorAll('.form-input, .form-select');
  formInputs.forEach(input => {
    input.addEventListener('focus', function() {
      this.parentNode.classList.add('focused');
    });
    
    input.addEventListener('blur', function() {
      this.parentNode.classList.remove('focused');
    });
  });
  
  // Add keyboard navigation improvements
  document.addEventListener('keydown', function(e) {
    // Enter key on inputs should move to next field instead of submitting
    if (e.key === 'Enter' && e.target.matches('input[type="number"]')) {
      e.preventDefault();
      const inputs = Array.from(document.querySelectorAll('input[type="number"], select'));
      const currentIndex = inputs.indexOf(e.target);
      const nextInput = inputs[currentIndex + 1];
      if (nextInput) {
        nextInput.focus();
      }
    }
  });
  
  // Add visual feedback for form sections
  const formSections = document.querySelectorAll('.bg-white.border.border-gray-200.rounded-xl');
  formSections.forEach(section => {
    const inputs = section.querySelectorAll('input, select');
    let focusedInput = null;
    
    inputs.forEach(input => {
      input.addEventListener('focus', function() {
        section.classList.add('ring-2', 'ring-blue-100');
        focusedInput = this;
      });
      
      input.addEventListener('blur', function() {
        // Small delay to check if focus moved to another input in the same section
        setTimeout(() => {
          if (!section.contains(document.activeElement)) {
            section.classList.remove('ring-2', 'ring-blue-100');
          }
        }, 10);
      });
    });
  });
  
  // Initialize all calculations on page load
  setTimeout(() => {
    calcBMI();
    calcBP();
    calcKes();
  }, 100);
});

// Enhanced error handling for form submissions
function handleFormError(form, message) {
  const submitBtn = form.querySelector('button[type="submit"]');
  if (submitBtn) {
    submitBtn.disabled = false;
    submitBtn.classList.remove('btn-loading');
    const originalText = submitBtn.getAttribute('data-original-text');
    if (originalText) {
      submitBtn.innerHTML = originalText;
    }
  }
  
  // Show error message if provided
  if (message) {
    // Create temporary error notification
    const errorDiv = document.createElement('div');
    errorDiv.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
    errorDiv.innerHTML = `
      <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
        </svg>
        <span>${message}</span>
      </div>
    `;
    document.body.appendChild(errorDiv);
    
    // Remove after 5 seconds
    setTimeout(() => {
      errorDiv.remove();
    }, 5000);
  }
}
</script>
