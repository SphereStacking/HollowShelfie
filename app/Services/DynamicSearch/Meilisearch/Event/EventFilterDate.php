<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use Carbon\Carbon;
use App\Services\DynamicSearch\Meilisearch\MeilisearchFilter;

/**
 * 日付クエリパラメータクラス
 */
class EventFilterDate extends MeilisearchFilter
{
    protected $column = 'start_date';

    public function formatValue()
    {
        ['start' => $start, 'end' => $end] = $this->value;
        return [Carbon::parse($start)->getTimestamp(), Carbon::parse($end)->getTimestamp()];
    }
}
