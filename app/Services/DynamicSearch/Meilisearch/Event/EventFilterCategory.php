<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use App\Services\DynamicSearch\Meilisearch\MeilisearchFilter;


/**
 * カテゴリクエリパラメータクラス
 */
class EventFilterCategory extends MeilisearchFilter
{
    protected $column = 'categories';

    public function formatValue()
    {
        return $this->value;
    }
}
