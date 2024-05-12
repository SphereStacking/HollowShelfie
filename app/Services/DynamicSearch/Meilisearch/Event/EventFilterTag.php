<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use App\Services\DynamicSearch\Meilisearch\MeilisearchFilter;

/**
 * タグクエリパラメータクラス
 */
class EventFilterTag extends MeilisearchFilter
{
    protected $column = 'tags';

    public function formatValue()
    {
        return $this->value;
    }
}
