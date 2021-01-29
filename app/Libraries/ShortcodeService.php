<?php

namespace App\Libraries;

class ShortcodeService {
    // Regex101 reference: https://regex101.com/r/pJ7lO1 (DANGER: OUTDATED!)
    const SHORTOCODE_REGEXP = "/(?P<shortcode>(?:(?:\\s?\\[))(?P<name>[\\w\\-]{3,})(?:\\s(?P<attrs>[\\w\\d,\\s=\\\"\\'\\-\\+\\#\\%\\!\\~\\`\\&\\.\\s\\:\\/\\?\\|]+))?(?:\\])(?:(?P<content>[\\w\\d\\,\\!\\@\\#\\$\\%\\^\\&\\*\\(\\\\)\\s\\=\\\"\\'\\-\\+\\&\\.\\s\\:\\/\\?\\|\\<\\>]+)(?:\\[\\/[\\w\\-\\_]+\\]))?)/u";

    // Regex101 reference: https://regex101.com/r/mfPWWB/1/
    const REF_REGEXP = "/(?P<shortcode>(?:(?:\s?\[))(?P<name>ref)(?:\])(?:(?P<content>.*)(?:\[\/ref\])))/uU";

    // Regex101 reference: https://regex101.com/r/sZ7wP0
    const ATTRIBUTE_REGEXP = "/(?<name>\\S+)=[\"']?(?P<value>(?:.(?![\"']?\\s+(?:\\S+)=|[>\"']))+.)[\"']?/u";

    public static function parse_ref($text)
    {
        return self::parse_text_with_regexp($text, self::REF_REGEXP);
    }

    public static function parse_shortcodes($text)
    {
        return self::parse_text_with_regexp($text, self::SHORTOCODE_REGEXP);
    }

    private static function parse_text_with_regexp($text, $regexp)
    {
        preg_match_all($regexp, $text, $matches, PREG_SET_ORDER);
        $shortcodes = array();
        foreach ($matches as $i => $value) {
            $shortcodes[$i]['shortcode'] = $value['shortcode'];
            $shortcodes[$i]['name'] = $value['name'];
            if (isset($value['attrs'])) {
                $attrs = self::parse_attrs($value['attrs']);
                $shortcodes[$i]['attrs'] = $attrs;
            }
            if (isset($value['content'])) {
                $shortcodes[$i]['content'] = $value['content'];
            }
        }

        return $shortcodes;
    }

    private static function parse_attrs($attrs)
    {
        preg_match_all(self::ATTRIBUTE_REGEXP, $attrs, $matches, PREG_SET_ORDER);
        $attributes = array();
        foreach ($matches as $i => $value) {
            $key = $value['name'];
            $attributes[$i][$key] = $value['value'];
        }
        return $attributes;
    }

}
