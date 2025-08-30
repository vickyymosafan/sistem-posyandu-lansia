-- Add measurement type for blood glucose to pemeriksaan
-- GDP (puasa), GDS (sewaktu), 2JAMPP (2 jam post-prandial)

ALTER TABLE pemeriksaan
  ADD COLUMN gula_tipe ENUM('puasa','sewaktu','2jpp') NULL AFTER gula_mgdl;
