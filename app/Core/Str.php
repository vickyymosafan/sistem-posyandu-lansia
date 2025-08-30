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
}

