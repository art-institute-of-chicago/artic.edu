<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validate the length of a string of HTML without the tags.
 */
class InnerTextLength implements ValidationRule
{
    public function __construct(
        protected int $min = 0,
        protected int $max = 0,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $innerText = strip_tags((string) $value);
        $length = mb_strlen($innerText);
        if ($length > $this->max) {
            $fail("The :attribute must be less than {$this->max} characters.");
        } elseif ($length < $this->min) {
            $fail("The :attribute must be greater than {$this->min} characters.");
        }
    }
}
