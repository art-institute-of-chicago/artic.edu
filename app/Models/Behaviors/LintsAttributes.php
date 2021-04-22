<?php

namespace App\Models\Behaviors;

trait LintsAttributes
{
    public function setAttribute($key, $value)
    {
        $value = $this->lintValue($value);

        return parent::setAttribute($key, $value);
    }

    private function lintValue($value)
    {
        if (is_object($value)) {
            foreach ($value as $key => $subvalue) {
                $value->$key = $this->lintValue($subvalue);
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
        $value = str_replace("\u{2028}", '', $value);

        // Zero-width nbps
        $value = str_replace("\u{FEFF}", '', $value);

        return $value;
    }
}
