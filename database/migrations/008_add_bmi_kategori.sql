-- Add BMI clinical classification column

ALTER TABLE pemeriksaan
  ADD COLUMN bmi_kategori ENUM('SANGAT_KURANG','KURANG','NORMAL','LEBIH','OBESITAS_I','OBESITAS_II') NULL AFTER bmi;

