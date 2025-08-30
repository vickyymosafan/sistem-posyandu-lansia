-- Add clinical classification for blood glucose
-- Stored as enum to support reporting/analytics

ALTER TABLE pemeriksaan
  ADD COLUMN gula_kategori ENUM('NORMAL','PRA_DIABETES','DIABETES','CURIGA_DIABETES') NULL AFTER gula_tipe;

