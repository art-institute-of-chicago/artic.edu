<?php

namespace App\Helpers;

class StringHelpers
{
    /**
     * Get Unicode slug
     * @see HasSlug::getUtf8Slug()
     */
    public static function getUtf8Slug($str, $options = [])
    {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string) $str, 'UTF-8', mb_list_encodings());

        $defaults = [
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => [],
            'transliterate' => true,
        ];

        // Merge options
        $options = array_merge($defaults, $options);

        $char_map = [
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',

            // Latin symbols
            '©' => '(c)',

            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',

            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

            // Kazakh
            'Ә' => 'A', 'Ғ' => 'G', 'Қ' => 'Q', 'Ң' => 'N', 'Ө' => 'O', 'Ұ' => 'U',
            'ә' => 'a', 'ғ' => 'g', 'қ' => 'q', 'ң' => 'n', 'ө' => 'o', 'ұ' => 'u',

            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',

            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',

            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z',

            // Romanian
            'Ă' => 'A', 'Â' => 'A', 'Î' => 'I', 'Ș' => 'S', 'Ț' => 'T',
            'ă' => 'a', 'â' => 'a', 'î' => 'i', 'ș' => 's', 'ț' => 't',
        ];

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }

        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }

    public static function truncateStr($string, $length = 150)
    {
        $limit = abs((int) $length);

        if ($limit > strlen($string)) {
            return $string;
        }

        $string = preg_replace("/^(.{1,${limit}})(\s.*|$)/s", '\1...', $string);

        if (strpos($string, '<') < 0) {
            return $truncatedString;
        }

        // https://stackoverflow.com/questions/16583676/shorten-text-without-splitting-words-or-breaking-html-tags
        preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $string, $result);
        $openedTags = $result[1];

        preg_match_all('#</([a-z]+)>#iU', $string, $result);
        $closedTags = $result[1];

        $openedLength = count($openedTags);

        if (count($closedTags) == $openedLength) {
            return $string;
        }

        $openedTags = array_reverse($openedTags);

        for ($i = 0; $i < $openedLength; $i++) {
            if (!in_array($openedTags[$i], $closedTags)) {
                $string .= '</' . $openedTags[$i] . '>';
            } else {
                unset($closedTags[array_search($openedTags[$i], $closedTags)]);
            }
        }

        return $string;
    }

    /**
     * PUB-137: Split the last "word" from a text. Used to keep reference
     * numbers and backref arrows from being orphaned onto the next line.
     *
     * Will *not* work with HTML! Plain text only.
     */
    public static function getLastWord($originalText)
    {
        $originalText = rtrim($originalText);
        preg_match('/(.* )([^<>]+)$$/', $originalText, $textParts);

        return [$textParts[1] ?? $originalText, $textParts[2] ?? ''];
    }

    public static function convertReferenceLinks($text, $_collectedReferences)
    {
        $codes = \App\Libraries\ShortcodeService::parse_ref($text);

        foreach ($codes as $index => $code) {
            if (isset($code['name']) && ($code['name'] == 'ref')) {
                $_collectedReferences[] = ['id' => sizeof($_collectedReferences) + 1, 'reference' => $code['content']];
                $pos = sizeof($_collectedReferences);
                $ref = '<sup id="ref_cite-' . $pos . '"><a href="#ref_note-' . $pos . '">[' . $pos . ']</a></sup>';

                $refPos = strpos($text, $code['shortcode']);
                $beforeRef = substr($text, 0, $refPos);
                $afterRef = substr($text, $refPos + strlen($code['shortcode']));

                [$beforeRefStart, $beforeRefEnd] = self::getLastWord($beforeRef);

                $text = ''
                    . $beforeRefStart
                    . '<span class="u-nowrap">'
                    . $beforeRefEnd
                    . $ref
                    . '</span>'
                    . $afterRef;
            }
        }

        return [$text, $_collectedReferences];
    }

    public static function properTitleCase($string)
    {
        // Exceptions in lowercase will be converted to lowercase
        // Exceptions in uppercase will be converted to uppercase
        // Exceptions in mixedcase will be have to match exact and be left untouched
        $exceptions = ['and', 'as', 'at', 'for', 'from', 'in', 'of', 'the', 'this', 'to', 'with',
            'GPS', 'U.S.',
            'd’Orsay', 'iOS', 'McQueen'];
        $delimiters = '“"-–-';
        $words = explode(' ', $string);

        $newwords = [];

        foreach ($words as $index => $word) {
            if ($index == 0) {
                $word = ucwords(strtolower($word), $delimiters);
            } elseif (in_array(strtoupper($word), $exceptions)) {
                $word = strtoupper($word);
            } elseif (in_array(strtolower($word), $exceptions)) {
                $word = strtolower($word);
            } elseif (in_array($word, $exceptions)) {
                $word = $word;
            } else {
                $word = ucwords(strtolower($word), $delimiters);
            }
            array_push($newwords, $word);
        }

        $string = implode(' ', $newwords);

        return $string;
    }

    /**
     * Remove a specific sequence of characters from the end of a string.
     * This is used in lieu of rtrim, which trims any combination of characters
     * from the end of a string.
     *
     * @see https://stackoverflow.com/a/32739088/1313842
     */
    public static function rightTrim($string, $needle)
    {
        if (is_string($string)) {
            while (
                (
                    strlen($string) >= strlen($needle)
                ) && (
                    strpos($string, $needle, strlen($string) - strlen($needle)) !== false
                )
            ) {
                $string = substr($string, 0, -strlen($needle));
            }
        }

        return $string;
    }

    /**
     * Helper method that converts `['item', 'hey', 'wow']` to `item, hey, and wow`.
     * Per request from communications, we use the Oxford comma.
     *
     * @return string
     */
    public static function summation(array $array = [])
    {
        switch (count($array)) {
            case 0:
                return null;
            case 1:
                return array_pop($array);

                break;
            case 2:
                return implode(' and ', $array);

                break;
            default:
                $last = array_pop($array);

                return implode(', ', $array) . ', and ' . $last;
        }
    }
}
