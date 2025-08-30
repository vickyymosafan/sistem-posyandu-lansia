-- Add clinical classification for uric acid and total cholesterol

ALTER TABLE pemeriksaan
  ADD COLUMN asam_urat_kategori ENUM('RENDAH','NORMAL','TINGGI') NULL AFTER asam_urat_mgdl,
  ADD COLUMN kolesterol_total_kategori ENUM('NORMAL','BATAS_TINGGI','TINGGI') NULL AFTER kolesterol_total_mgdl;

