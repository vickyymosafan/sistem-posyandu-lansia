-- Add lipid profile columns to pemeriksaan
-- Run this after 001_init.sql

ALTER TABLE pemeriksaan
  ADD COLUMN kolesterol_total_mgdl SMALLINT UNSIGNED NULL AFTER gula_mgdl,
  ADD COLUMN kolesterol_ldl_mgdl SMALLINT UNSIGNED NULL AFTER kolesterol_total_mgdl,
  ADD COLUMN kolesterol_hdl_mgdl SMALLINT UNSIGNED NULL AFTER kolesterol_ldl_mgdl,
  ADD COLUMN trigliserida_mgdl SMALLINT UNSIGNED NULL AFTER kolesterol_hdl_mgdl;

-- Note: legacy column kolesterol_mgdl (if present) is still supported by the app
-- as a fallback for kolesterol_total_mgdl.

