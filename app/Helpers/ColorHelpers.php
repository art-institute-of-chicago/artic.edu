<?php

namespace App\Helpers;

/**
 * @link https://gist.github.com/bedeabza/10463089
 */
class ColorHelpers
{
    public static function hexToHsl($hex)
    {
        $hex = [$hex[0] . $hex[1], $hex[2] . $hex[3], $hex[4] . $hex[5]];
        $rgb = array_map(function ($part) {
            return hexdec($part) / 255;
        }, $hex);

        $max = max($rgb);
        $min = min($rgb);

        $l = ($max + $min) / 2;

        if ($max == $min) {
            $h = $s = 0;
        } else {
            $diff = $max - $min;
            $s = $l > 0.5 ? $diff / (2 - $max - $min) : $diff / ($max + $min);

            switch ($max) {
                case $rgb[0]:
                    $h = ($rgb[1] - $rgb[2]) / $diff + ($rgb[1] < $rgb[2] ? 6 : 0);

                    break;
                case $rgb[1]:
                    $h = ($rgb[2] - $rgb[0]) / $diff + 2;

                    break;
                case $rgb[2]:
                    $h = ($rgb[0] - $rgb[1]) / $diff + 4;

                    break;
            }

            $h /= 6;
        }

        return [$h, $s, $l];
    }

    public static function hslToHex($hsl)
    {
        [$h, $s, $l] = $hsl;

        if ($s == 0) {
            $r = $g = $b = 1;
        } else {
            $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
            $p = 2 * $l - $q;

            $r = static::hue2rgb($p, $q, $h + 1 / 3);
            $g = static::hue2rgb($p, $q, $h);
            $b = static::hue2rgb($p, $q, $h - 1 / 3);
        }

        return static::rgb2hex($r) . static::rgb2hex($g) . static::rgb2hex($b);
    }

    public static function hue2rgb($p, $q, $t)
    {
        if ($t < 0) {
            $t += 1;
        }
        if ($t > 1) {
            $t -= 1;
        }
        if ($t < 1 / 6) {
            return $p + ($q - $p) * 6 * $t;
        }
        if ($t < 1 / 2) {
            return $q;
        }
        if ($t < 2 / 3) {
            return $p + ($q - $p) * (2 / 3 - $t) * 6;
        }

        return $p;
    }

    public static function rgb2hex($rgb)
    {
        return str_pad(dechex($rgb * 255), 2, '0', STR_PAD_LEFT);
    }
}
