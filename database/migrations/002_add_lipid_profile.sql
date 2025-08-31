

ALTER TABLE pemeriksaan
  ADD COLUMN kolesterol_total_mgdl SMALLINT UNSIGNED NULL AFTER gula_mgdl,
  ADD COLUMN kolesterol_ldl_mgdl SMALLINT UNSIGNED NULL AFTER kolesterol_total_mgdl,
