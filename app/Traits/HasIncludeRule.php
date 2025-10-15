<?php

namespace App\Traits;

use App\Rules\AllowIncludes;

trait HasIncludeRule
{
    protected function includeRule(array $allowed = [])
    {
        return ['nullable', 'string', new AllowIncludes($allowed)];
    }

    public function includeStrToArray(string $include)
    {
        return str_replace('-', '.', explode(',', $include));
    }
}
