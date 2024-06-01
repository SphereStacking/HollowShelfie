<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use Carbon\Carbon;
use App\Services\DynamicSearch\Meilisearch\MeilisearchSystemFilter;

/**
 * Event作成者クエリパラメータクラス
 */
class EventSystemFilterPublished extends MeilisearchSystemFilter
{
    public function makeQuery()
    {
        return 'is_forced_hidden = false AND published_at < ' . Carbon::now()->getTimestamp();
    }
}
