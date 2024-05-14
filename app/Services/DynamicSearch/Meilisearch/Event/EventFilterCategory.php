<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use App\Models\Category;
use App\Services\DynamicSearch\Meilisearch\MeilisearchFilter;


/**
 * カテゴリクエリパラメータクラス
 */
class EventFilterCategory extends MeilisearchFilter
{
    protected $column = 'category_ids';

    public function formatValue()
    {
        return Category::where('name', $this->value)->value('id');
    }
}
