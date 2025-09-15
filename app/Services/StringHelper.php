<?php

namespace App\Services;

class StringHelper
{
    public static function censorName($name)
    {
        if (!$name) {
            return '-';
        }

        $parts = explode(' ', $name);

        $censoredParts = array_map(function ($part) {
            $length = strlen($part);
            if ($length <= 2) {
                return $part; // kalau terlalu pendek biarin aja
            }

            $first = strtoupper($part[0]);
            $last = strtoupper($part[$length - 1]);

            // isi tengah jadi bintang
            return $first . str_repeat('*', $length - 2) . $last;
        }, $parts);

        return implode(' ', $censoredParts);
    }
}
