<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IntegerArray implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        array_walk_recursive($value, function ($item) use ($fail, $attribute) {
            if (!is_int($item)) $fail($attribute . 'can only be integer'); //check all items of array, if is not integer validation returns false to show json error.
        });
    }
    
}
