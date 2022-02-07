<?php

namespace App\Models\Behaviors;

trait LintsAttributes
{
    protected function lintValue($value)
    {
        if (is_object($value)) {
            foreach ($value as $key => $subvalue) {
                $value->{$key} = $this->lintValue($subvalue);
            }
        }

        if (is_string($value)) {
            $value = $this->lintBadUnicode($value);
        }

        return $value;
    }

    /**
     * Removes certain characters that only show up in Chrome on Windows.
     *
     * @link https://art-institute-of-chicago.atlassian.net/browse/WEB-927
     * @link https://stackoverflow.com/questions/39603446
     */
    private function lintBadUnicode($value)
    {
        // Line separator
        $value = str_replace(json_decode('"\u2028"'), '', $value);

        // Zero-width nbps
        $value = str_replace(json_decode('"\uFEFF"'), '', $value);

        // Zero-width space
        $value = str_replace(json_decode('"\u200B"'), '', $value);

        return $value;
    }
}
