<?php

namespace App\Helpers;

class DigitalExplorerHelpers
{
    /**
     * Encodes a value (array or scalar) into a string setting.
     * Arrays are encoded as "[v1, v2, ...]".
     *
     * @param mixed $val
     * @return string
     */
    public static function encodeSettings($val): string
    {
        if (is_array($val)) {
            return '[' . implode(', ', $val) . ']';
        }
        return (string)$val;
    }

    /**
     * Decodes a "[v1, v2, ...]" string into a float array.
     *
     * @param string|null $values
     * @param array $default
     * @return array
     */
    public static function decodeSettings(?string $values, array $default = []): array
    {
        if (!$values) {
            return $default;
        }

        $values = trim($values, '[]');
        if (empty($values)) {
            return $default;
        }

        $parts = array_map('trim', explode(',', $values));

        return array_map('floatval', $parts);
    }
}
