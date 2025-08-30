-- Add blood pressure category classification column (AHA-based)

ALTER TABLE pemeriksaan
  ADD COLUMN tekanan_darah_kategori ENUM('NORMAL','BATAS_WASPADA','HIPERTENSI_TAHAP_1','HIPERTENSI_TAHAP_2','KRISIS_HIPERTENSI') NULL AFTER diastolik;

