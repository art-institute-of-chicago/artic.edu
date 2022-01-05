<?php

namespace App\Libraries;

use Michelf\SmartyPants as BasePants;

class SmartyPants extends BasePants
{
    /**
     * Override parent method to prevent it from transforming `null` to empty string.
     */
    public static function defaultTransform($text, $attr = SmartyPants::ATTR_DEFAULT)
    {
        if (!isset($text)) {
            return null;
        }

        return parent::defaultTransform(...func_get_args());
    }
}
