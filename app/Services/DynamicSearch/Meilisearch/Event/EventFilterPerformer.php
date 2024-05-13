<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use Carbon\Carbon;
use App\Services\DynamicSearch\Meilisearch\MeilisearchFilter;

/**
 * Performerクエリパラメータクラス
 */
class EventFilterPerformer extends MeilisearchFilter
{
    protected $column = 'performers';

    public function formatValue()
    {
        return $this->value;
    }
}
