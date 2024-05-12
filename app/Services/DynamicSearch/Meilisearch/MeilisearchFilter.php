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

    /**
     * 条件マップ
     *
     * @var array
     */
    public $conditionMaps = [
        'and' => 'where',
        'or' => 'WhereOr',
        'not' => 'whereNot',
    ];

    public function __construct($include, $type, $value)
    {
        $this->include = $include;
        $this->type = $type;
        $this->value = $value;
    }

    public function makeQuery(): string
    {
        $method = $this->conditionMaps[$this->include];

        return $this->$method($this->formatValue());
    }

    protected function where($value): string
    {
        if (is_array($value)) {
            return " AND ({$this->column} > {$value[0]} AND {$this->column} < {$value[1]})";
        } else {
            $value = is_numeric($value) ? $value : "\"{$value}\"";
            return " AND {$this->column} = {$value}";
        }
    }

    protected function whereOr($value): string
    {
        if (is_array($value)) {
            return " OR ({$this->column} > {$value[0]} AND {$this->column} < {$value[1]})";
        } else {
            $value = is_numeric($value) ? $value : "\"{$value}\"";
            return " OR {$this->column} = {$value}";
        }
    }

    protected function whereNot($value): string
    {
        $value = is_numeric($value) ? $value : "\"{$value}\"";
        return " AND NOT {$this->column} = {$value}";
    }


    /**
     * 値をフォーマットする
     */
    abstract public function formatValue();
}
