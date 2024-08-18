<?php

namespace App\Services\DynamicSearch\Meilisearch;

use Illuminate\Support\Collection;

/**
 * クエリパラメータ抽象クラス
 */
abstract class MeilisearchArrayFilter implements MeilisearchFilterInterface
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

    protected function where(Collection $value): string
    {
        $query = " ({$this->column} IN {$value})";
        if (!$this->isFirst) {
            $query = " AND " . $query;
        }
        return $query;
    }

    protected function whereOr(Collection $value): string
    {
        $query = " ({$this->column} IN {$value})";
        if (!$this->isFirst) {
            $query = " OR " . $query;
        }

        return $query;
    }

    protected function whereNot(Collection $value): string
    {
        $query = " ({$this->column} NOT IN {$value})";
        if (!$this->isFirst) {
            $query = " AND  " . $query;
        }
        return $query;
    }

    /**
     * 値をフォーマットする
     */
    abstract public function formatValue(): Collection;
}
