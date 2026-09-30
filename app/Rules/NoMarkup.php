<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validate that a string contains no HTML or PHP tags.
 *
 * Only a `<` directly followed by a letter, `/`, `!` or `?` is treated as
 * markup, so plain text such as "I <3 art" or "a < b" is still allowed.
 */
class NoMarkup implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_string($value) && preg_match('/<[a-z\/!?]/i', $value)) {
            $fail('The :attribute must not contain HTML.');
        }
    }
}
