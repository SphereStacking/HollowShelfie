<?php

namespace App\Rules;

use App\Traits\HasFollowable;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use ReflectionClass;

class FollowableType implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $errorMessage = ':attribute is not a followable target.';
        if (! class_exists($value)) {
            $fail($errorMessage);
        }
        $reflectionClass = new ReflectionClass($value);
        $getTraits = $reflectionClass->getTraitNames();
        if (! in_array(HasFollowable::class, $getTraits)) {
            $fail($errorMessage);
        }
    }
}
