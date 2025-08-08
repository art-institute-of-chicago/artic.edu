<?php

namespace App\Libraries;

class ShortcodeService
{
    // Regex101 reference: https://regex101.com/r/5dOPYU/1
    public const REF_REGEXP = "/(?P<shortcode>(?:(?:\s?\[))(?P<name>ref)(?:\])(?:(?P<content>.*)(?:\[\/ref\])))/uU";

    // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public static function parse_ref($text)
    {
        preg_match_all(self::REF_REGEXP, $text, $matches, PREG_SET_ORDER);
        $filter = fn ($captureGroup) => is_string($captureGroup);
        return array_map(fn ($match) => array_filter($match, $filter, ARRAY_FILTER_USE_KEY), $matches);
    }
}
