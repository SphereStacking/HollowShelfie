<?php

namespace App\Services\DynamicSearch\Meilisearch;

/**
 * クエリパラメータ抽象クラス
 */
abstract class MeilisearchFilter implements MeilisearchFilterInterface
{
    protected $column;

    public $include;

    public $type;

    public $value;

    public $isFirst;

    public function __construct($include, $type, $value, $isFirst)
    {
        $this->include = $include;
        $this->type = $type;
        $this->value = $value;
        $this->isFirst = $isFirst;
    }

    public function makeQuery(): string
    {
        return match ($this->include) {
            'and' => $this->where($this->formatValue()),
            'or' => $this->whereOr($this->formatValue()),
            'not' => $this->whereNot($this->formatValue()),
            default => throw new \Exception('Invalid include value'),
        };
    }

    protected function where($value): string
    {
        $query = "";
        if (is_array($value)) {
            $query = " ({$this->column} > {$value[0]} AND {$this->column} < {$value[1]})";
        } else {
            $value = is_numeric($value) ? $value : "\"{$value}\"";
            $query = " {$this->column} = {$value}";
        }
        if (!$this->isFirst) {
            $query = " AND " . $query;
        }
        return $query;
    }

    protected function whereOr($value): string
    {
        $query = "";
        if (is_array($value)) {
            $query = " ({$this->column} > {$value[0]} AND {$this->column} < {$value[1]})";
        } else {
            $value = is_numeric($value) ? $value : "\"{$value}\"";
            $query = " {$this->column} = {$value}";
        }

        if (!$this->isFirst) {
            $query = " OR " . $query;
        }

        return $query;
    }

    protected function whereNot($value): string
    {
        $value = is_numeric($value) ? $value : "\"{$value}\"";
        $query = " {$this->column} = {$value}";
        if (!$this->isFirst) {
            $query = " AND NOT " . $query;
        }
        return $query;
    }

    /**
     * 値をフォーマットする
     */
    abstract public function formatValue();
}
