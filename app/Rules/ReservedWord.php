<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * 予約語チェック
 */
class ReservedWord implements ValidationRule
{
    protected $categories;

    public function __construct($categories = null)
    {
        if ($categories === null) {
            // カテゴリが指定されていない場合は、すべてのカテゴリを取得
            $this->categories = array_keys(config('reserved_words'));
        } else {
            // カテゴリが指定されている場合は、それを配列として保存
            $this->categories = is_array($categories) ? $categories : [$categories];
        }
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $reservedWords = [];
        foreach ($this->categories as $category) {
            $reservedWords = array_merge($reservedWords, config('reserved_words.'.$category, []));
        }
        if (in_array($value, $reservedWords)) {
            $fail(':attributeは予約語です。');
        }
    }
}
