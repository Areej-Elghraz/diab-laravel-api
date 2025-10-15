<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AllowIncludes implements ValidationRule
{
    protected array $allowed;

    public function __construct(array $allowed)
    {
        $this->allowed = $allowed;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $includes = explode(',', $value ?? '');

        foreach ($includes as $relation) {
            if ($relation && ! in_array($relation, $this->allowed)) {
                $fail("The relation '$relation' is not allowed for $attribute.");
            }
        }
    }
}
