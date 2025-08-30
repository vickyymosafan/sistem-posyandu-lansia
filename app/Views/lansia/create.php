<?php
$errors = $errors ?? [];
$old = $old ?? [];
function err($f,$e){ return isset($e[$f]) ? '<p class="text-red-600 text-sm mt-1">'.htmlspecialchars($e[$f]).'</p>' : ''; }
?>
<div class="max-w-2xl">
  <h1 class="text-xl md:text-2xl font-bold tracking-tight mb-4">Pendaftaran Lansia</h1>
  <form class="space-y-4 bg-white/80 backdrop-blur border rounded-xl p-4" method="post" action="/lansia" onsubmit="return validateForm(this)">
    <div>
      <label class="block text-sm mb-1" for="nama_lengkap">Nama Lengkap</label>
      <input class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="text" id="nama_lengkap" name="nama_lengkap" required maxlength="150" value="<?= htmlspecialchars($old['nama_lengkap'] ?? '') ?>">
      <?= err('nama_lengkap', $errors) ?>
    </div>
    <div>
      <label class="block text-sm mb-1" for="tgl_lahir">Tanggal Lahir</label>
      <input class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="date" id="tgl_lahir" name="tgl_lahir" required value="<?= htmlspecialchars($old['tgl_lahir'] ?? '') ?>" oninput="hitungUsiaLive()" onchange="hitungUsiaLive()">
      <p id="usiaLive" class="text-xs text-gray-600 mt-1"></p>
      <?= err('tgl_lahir', $errors) ?>
    </div>
    <div>
      <label class="block text-sm mb-1">Jenis Kelamin</label>
      <div class="flex items-center gap-4">
        <label class="inline-flex items-center gap-2"><input type="radio" name="jk" value="L" required <?= (($old['jk'] ?? '')==='L')?'checked':''; ?>> <span>Laki-laki</span></label>
        <label class="inline-flex items-center gap-2"><input type="radio" name="jk" value="P" required <?= (($old['jk'] ?? '')==='P')?'checked':''; ?>> <span>Perempuan</span></label>
      </div>
      <?= err('jk', $errors) ?>
    </div>
    <div>
      <label class="block text-sm mb-1" for="alamat">Alamat Lengkap</label>
      <textarea class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" id="alamat" name="alamat" required rows="3"><?= htmlspecialchars($old['alamat'] ?? '') ?></textarea>
      <?= err('alamat', $errors) ?>
    </div>
    <div>
      <label class="block text-sm mb-1" for="no_telp">Nomor Telepon</label>
      <input class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="tel" id="no_telp" name="no_telp" required placeholder="08xxxxxxxxxx" value="<?= htmlspecialchars($old['no_telp'] ?? '') ?>">
      <p class="text-xs text-gray-500 mt-1">Format Indonesia, contoh: 08xxxxxxxxxx / +628xxxxxxxxxx</p>
      <?= err('no_telp', $errors) ?>
    </div>
    <div class="pt-2">
      <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 active:scale-[.99]" type="submit" onclick="haptic()">Daftarkan</button>
    </div>
  </form>
</div>

<script>
function validateForm(form){
  const tel = form.no_telp.value.trim();
  const re = /^(?:\+62|62|0)8[1-9][0-9]{7,10}$/;
  if(!re.test(tel)){
    alert('Nomor telepon tidak valid');
    form.no_telp.focus();
    return false;
  }
  // simple loading indicator
  const btn = form.querySelector('button[type="submit"]');
  if(btn){ btn.disabled = true; btn.textContent = 'Menyimpan...'; }
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
document.addEventListener('DOMContentLoaded', hitungUsiaLive);
</script>
