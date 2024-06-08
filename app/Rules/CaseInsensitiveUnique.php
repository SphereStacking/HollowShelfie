<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * 大文字小文字を区別しないユニークチェック
 */
class CaseInsensitiveUnique implements ValidationRule
{
    protected string $table;

    protected string $column;

    public $extraConditions;

    public function __construct($table, $column, array $extraConditions = [])
    {
        $this->table = $table;

        $this->column = $column;

        $this->extraConditions = $extraConditions;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $count = DB::table($this->table)
            ->whereRaw("lower({$this->column}) = lower(?)", [$value]);

        if ( !blank($this->extraConditions) ) {
            foreach ($this->extraConditions as $columnCollection) {

                if ( !isset($columnCollection['column']) || !isset($columnCollection['operator']) || !isset($columnCollection['value']) ) {
                    continue;
                }

                if ( $columnCollection['operator'] === 'null' ) {
                    $count = $count->whereNull($columnCollection['column']);
                    continue;
                }

                if ( $columnCollection['operator'] === 'in' ) {
                    $count = $count->whereIn($columnCollection['column'], $columnCollection['value']);
                    continue;
                }

                if ( $columnCollection['operator'] === 'notNull' ) {
                    $count = $count->whereNotNull($columnCollection['column']);
                    continue;
                }

                $count = $count->where($columnCollection['column'], $columnCollection['operator'], $columnCollection['value']);

            }
        }

        if ($count->count() > 0) {
            $fail(':attributeは既に使用されています。');
        }

    }
}
