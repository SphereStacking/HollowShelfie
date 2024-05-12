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
        if (is_string($this->value) && mb_strpos($this->value, '~') !== false) {
            [$start, $end] = explode('~', $this->value);

            return [Carbon::parse($start)->getTimestamp(), Carbon::parse($end)->getTimestamp()];
        }

        return $this->value;
    }
}
