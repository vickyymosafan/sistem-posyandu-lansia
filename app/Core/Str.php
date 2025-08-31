<?php
namespace App\Core;

class Str
{
    public static function randomBase62(int $length = 10): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLen = strlen($chars);
        $bytes = random_bytes($length);
        $out = '';
        for ($i = 0; $i < $length; $i++) {
            $out .= $chars[ord($bytes[$i]) % $charLen];
        }
        return $out;
    }

    // Generate patient ID with prefix 'pasien' + YYYYMMDD + 2 base62 chars (total length 16)
    public static function patientId(?\DateTimeInterface $when = null): string
    {
        $d = ($when ?: new \DateTime())->format('Ymd');
        // Two base62 characters for up to 3844 combinations per day
        $suffix = self::randomBase62(2);
        return 'pasien' . $d . $suffix; // 6 + 8 + 2 = 16 chars fits schema
    }
}
