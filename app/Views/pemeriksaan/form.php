<?php
// $l: lansia row
function ferr($e,$f){ return isset($e[$f])?'<p class="text-red-600 text-sm mt-1">'.htmlspecialchars($e[$f]).'</p>':''; }
?>
<div class="space-y-6">
  <?php if (!empty($success)): ?>
    <div class="p-3 rounded border border-green-300 bg-green-50 text-green-800"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <div class="bg-white border rounded p-4">
    <h2 class="font-semibold mb-3">Data Lansia</h2>
    <div class="grid sm:grid-cols-2 gap-3 text-sm">
      <div><span class="text-gray-600">Nama:</span> <span class="font-medium"><?= htmlspecialchars($l['nama_lengkap']) ?></span></div>
      <div><span class="text-gray-600">ID Unik:</span> <span class="font-mono font-medium"><?= htmlspecialchars($l['id_unik']) ?></span></div>
      <div><span class="text-gray-600">Tanggal Lahir:</span> <span class="font-medium"><?= htmlspecialchars($l['tgl_lahir']) ?></span></div>
      <div>
        <span class="text-gray-600">Usia:</span>
        <span class="font-medium">
          <?php
            try {
              $dob = new DateTime($l['tgl_lahir']);
              $diff = $dob->diff(new DateTime());
              echo htmlspecialchars($diff->y . ' tahun' . ($diff->m>0 ? ' ' . $diff->m . ' bulan' : ''));
            } catch (Throwable $e) { echo '-'; }
          ?>
        </span>
      </div>
      <div><span class="text-gray-600">Jenis Kelamin:</span> <span class="font-medium"><?= $l['jk']==='L'?'Laki-laki':'Perempuan' ?></span></div>
    </div>
  </div>

  <div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white/80 backdrop-blur border rounded-xl p-4">
      <h2 class="font-semibold mb-3">Pemeriksaan Fisik</h2>
      <form method="post" action="/lansia/<?= htmlspecialchars($l['id_unik']) ?>/pemeriksaan/fisik" class="space-y-3" onsubmit="return valFisik(this)">
        <div>
          <label class="block text-sm mb-1" for="tinggi_cm">Tinggi Badan (cm)</label>
          <input class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="number" id="tinggi_cm" name="tinggi_cm" min="100" max="200" required value="<?= htmlspecialchars($old_fisik['tinggi_cm'] ?? '') ?>">
          <?= ferr($errors_fisik ?? [], 'tinggi_cm') ?>
        </div>
        <div>
          <label class="block text-sm mb-1" for="berat_kg">Berat Badan (kg)</label>
          <input class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="number" step="0.1" id="berat_kg" name="berat_kg" min="30" max="150" required value="<?= htmlspecialchars($old_fisik['berat_kg'] ?? '') ?>">
          <?= ferr($errors_fisik ?? [], 'berat_kg') ?>
        </div>
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-sm mb-1" for="sistolik">Sistolik (mmHg)</label>
            <input class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="number" id="sistolik" name="sistolik" min="70" max="250" required value="<?= htmlspecialchars($old_fisik['sistolik'] ?? '') ?>">
            <?= ferr($errors_fisik ?? [], 'sistolik') ?>
          </div>
          <div>
            <label class="block text-sm mb-1" for="diastolik">Diastolik (mmHg)</label>
            <input class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="number" id="diastolik" name="diastolik" min="40" max="150" required value="<?= htmlspecialchars($old_fisik['diastolik'] ?? '') ?>">
            <?= ferr($errors_fisik ?? [], 'diastolik') ?>
          </div>
        </div>
        <p id="bpLive" class="text-sm text-gray-600"></p>
        <div class="pt-2">
          <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 active:scale-[.99]" type="submit" onclick="haptic()">Simpan Pemeriksaan Fisik</button>
        </div>
        <p id="bmiLive" class="text-sm text-gray-600"></p>
        </form>

      <!-- Tren fisik dipindahkan ke grid horizontal di sisi kanan -->
    </div>

    <div class="bg-white/80 backdrop-blur border rounded-xl p-4">
      <h2 class="font-semibold mb-3">Pemeriksaan Kesehatan</h2>
      <form method="post" action="/lansia/<?= htmlspecialchars($l['id_unik']) ?>/pemeriksaan/kesehatan" class="space-y-3" onsubmit="return valKes(this)">
        <div>
          <label class="block text-sm mb-1" for="asam_urat_mgdl">Asam Urat (mg/dL)</label>
          <input class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="number" step="0.1" id="asam_urat_mgdl" name="asam_urat_mgdl" min="2.0" max="15.0" required value="<?= htmlspecialchars($old_kesehatan['asam_urat_mgdl'] ?? '') ?>">
          <?= ferr($errors_kesehatan ?? [], 'asam_urat_mgdl') ?>
        </div>
        <div>
          <label class="block text-sm mb-1" for="gula_mgdl">Gula Darah (mg/dL)</label>
          <input class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="number" id="gula_mgdl" name="gula_mgdl" min="50" max="500" required value="<?= htmlspecialchars($old_kesehatan['gula_mgdl'] ?? '') ?>">
          <?= ferr($errors_kesehatan ?? [], 'gula_mgdl') ?>
        </div>
        <div>
          <label class="block text-sm mb-1" for="gula_tipe">Tipe Pemeriksaan Gula</label>
          <select class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="gula_tipe" name="gula_tipe" required>
            <?php $gt = $old_kesehatan['gula_tipe'] ?? ''; ?>
            <option value="" <?= $gt===''?'selected':'' ?>>Pilih tipe</option>
            <option value="puasa" <?= $gt==='puasa'?'selected':'' ?>>GDP (Puasa)</option>
            <option value="sewaktu" <?= $gt==='sewaktu'?'selected':'' ?>>GDS (Sewaktu)</option>
            <option value="2jpp" <?= $gt==='2jpp'?'selected':'' ?>>2 Jam Setelah Makan</option>
          </select>
          <?= ferr($errors_kesehatan ?? [], 'gula_tipe') ?>
        </div>
        <div>
          <label class="block text-sm mb-1" for="kolesterol_total_mgdl">Kolesterol Total (mg/dL)</label>
          <input class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="number" id="kolesterol_total_mgdl" name="kolesterol_total_mgdl" min="100" max="400" required value="<?= htmlspecialchars($old_kesehatan['kolesterol_total_mgdl'] ?? '') ?>">
          <?= ferr($errors_kesehatan ?? [], 'kolesterol_total_mgdl') ?>
        </div>
        <div id="ketKesLive" class="text-sm text-gray-600"></div>
        
        <div class="pt-2">
          <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 active:scale-[.99]" type="submit" onclick="haptic()">Simpan Pemeriksaan Kesehatan</button>
        </div>
      </form>

      <!-- Bagian tren grafik dihapus sesuai permintaan -->
    </div>
  </div>
</div>


<script>
function valFisik(f){
  const toCheck=[['tinggi_cm',100,200],['berat_kg',30,150],['sistolik',70,250],['diastolik',40,150]];
  for(const [id,min,max] of toCheck){
    const el=f[id]; const v=parseFloat(el.value);
    if(isNaN(v) || v<min || v>max){ alert(id.replace('_',' ')+' harus antara '+min+'-'+max); el.focus(); return false; }
  }
  const btn=f.querySelector('button[type="submit"]'); if(btn){btn.disabled=true; btn.textContent='Menyimpan...';}
  return true;
}

function valKes(f){
  const required=[['asam_urat_mgdl',2.0,15.0],['gula_mgdl',50,500],['kolesterol_total_mgdl',100,400]];
  const optional=[];
  // gula_tipe required in select
  const gulaTipe=f['gula_tipe']?.value||''; if(!['puasa','sewaktu','2jpp'].includes(gulaTipe)){ alert('Pilih tipe pemeriksaan gula'); f['gula_tipe'].focus(); return false; }
  for(const [id,min,max] of required){
    const el=f[id]; const v=parseFloat(el.value);
    if(isNaN(v) || v<min || v>max){ alert(id.replace('_',' ')+' harus antara '+min+'-'+max); el.focus(); return false; }
  }
  for(const [id,min,max] of optional){
    const el=f[id]; if(!el) continue; const raw=el.value.trim(); if(raw==='') continue; const v=parseFloat(raw);
    if(isNaN(v) || v<min || v>max){ alert(id.replace('_',' ')+' harus antara '+min+'-'+max); el.focus(); return false; }
  }
  const btn=f.querySelector('button[type="submit"]'); if(btn){btn.disabled=true; btn.textContent='Menyimpan...';}
  return true;
}

// Live BMI preview
const tinggi=document.getElementById('tinggi_cm');
const berat=document.getElementById('berat_kg');
const sistolik=document.getElementById('sistolik');
const diastolik=document.getElementById('diastolik');
const bmiLive=document.getElementById('bmiLive');
const bpLive=document.getElementById('bpLive');
function bmiKategoriLabel(bmi){
  if (bmi < 17.0) return 'Berat Badan Sangat Kurang';
  if (bmi < 18.5) return 'Berat Badan Kurang';
  if (bmi <= 25.0) return 'Berat Badan Normal';
  if (bmi <= 27.0) return 'Kelebihan Berat Badan (Overweight)';
  if (bmi <= 30.0) return 'Obesitas Tingkat I';
  return 'Obesitas Tingkat II';
}
function calcBMI(){
  const t=parseFloat(tinggi?.value||''); const b=parseFloat(berat?.value||'');
  if(t && b){
    const bmi=+(b/((t/100)**2)).toFixed(1);
    const label=bmiKategoriLabel(bmi);
    bmiLive.textContent='Perkiraan BMI: '+bmi+' ('+label+')';
  } else {
    bmiLive.textContent='';
  }
}
function bpKategoriLabel(s, d){
  if (!s || !d) return '';
  const sys = parseInt(s, 10); const dia = parseInt(d, 10);
  if (sys>180 || dia>120) return 'Krisis Hipertensi';
  if (sys>=140 || dia>=90) return 'Hipertensi Tahap 2';
  if (sys>=130 || (dia>=80 && dia<=89)) return 'Hipertensi Tahap 1';
  if (sys>=120 && sys<=129 && dia<80) return 'Batas Waspada (Elevated)';
  return 'Normal';
}
function calcBP(){
  const sVal = sistolik?.value || '';
  const dVal = diastolik?.value || '';
  if (sVal && dVal){
    const label = bpKategoriLabel(sVal, dVal);
    bpLive.textContent = 'Perkiraan Tekanan Darah: ' + sVal + '/' + dVal + ' mmHg (' + label + ')';
  } else {
    bpLive.textContent = '';
  }
}
if(tinggi){ tinggi.addEventListener('input',calcBMI); }
if(berat){ berat.addEventListener('input',calcBMI); }
if(sistolik){ sistolik.addEventListener('input',calcBP); }
if(diastolik){ diastolik.addEventListener('input',calcBP); }
calcBP();

// Live Keterangan Kesehatan
const jk = <?= json_encode($l['jk'] ?? 'L') ?>; // 'L' atau 'P'
const gulaEl = document.getElementById('gula_mgdl');
const gulaTipeEl = document.getElementById('gula_tipe');
const kolEl = document.getElementById('kolesterol_total_mgdl');
const asamEl = document.getElementById('asam_urat_mgdl');
const ketKesLive = document.getElementById('ketKesLive');

function kelasGula(val, tipe){
  if(!val || !tipe) return '';
  const v = parseInt(val, 10);
  if (tipe === 'puasa') {
    if (v >= 126) return 'DIABETES';
    if (v >= 100) return 'PRA_DIABETES';
    return 'NORMAL';
  } else if (tipe === '2jpp') {
    if (v >= 200) return 'DIABETES';
    if (v >= 140) return 'PRA_DIABETES';
    return 'NORMAL';
  } else if (tipe === 'sewaktu') {
    // Tidak ada 'CURIGA_DIABETES': GDS >= 200 dikategorikan 'DIABETES'.
    if (v >= 200) return 'DIABETES';
    return 'NORMAL';
  }
  return '';
}

function kelasKol(val){
  if(!val) return '';
  const v = parseInt(val, 10);
  if (v >= 240) return 'Tinggi';
  if (v >= 200) return 'Batas tinggi';
  return 'Normal';
}

function kelasAsam(val){
  if(!val) return '';
  const v = parseFloat(val);
  const low = jk === 'L' ? 3.4 : 2.4;
  const high = jk === 'L' ? 7.0 : 6.0;
  if (v < low) return 'Rendah';
  if (v > high) return 'Tinggi';
  return 'Normal';
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
  const gulaK = kelasGula(gv, gt);
  const kolK = kelasKol(kv);
  const asamK = kelasAsam(av);

  let parts = [];
  if (gv) {
    let note = '';
    if (gt==='sewaktu' && gulaK==='DIABETES') note = ' - Perlu gejala khas untuk menegakkan diagnosis';
    parts.push(`Gula: ${gv} mg/dL (${labelGulaTipe(gt)}${gulaK? ' => '+gulaK:''})${note}`);
  }
  if (kv) parts.push(`Kolesterol Total: ${kv} mg/dL (${kolK})`);
  if (av) parts.push(`Asam Urat: ${av} mg/dL (${asamK})`);
  ketKesLive.textContent = parts.length ? ('Keterangan: ' + parts.join('; ')) : '';
}

if (gulaEl) gulaEl.addEventListener('input', calcKes);
if (gulaTipeEl) gulaTipeEl.addEventListener('change', calcKes);
if (kolEl) kolEl.addEventListener('input', calcKes);
if (asamEl) asamEl.addEventListener('input', calcKes);
calcKes();

// Chart.js dan tren dihapus, tidak ada pemanggilan grafik.
</script>
