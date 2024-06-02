<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use App\Models\ScreenName;
use App\Services\DynamicSearch\Meilisearch\MeilisearchFilter;

/**
 * Performerクエリパラメータクラス
 */
class EventFilterPerformer extends MeilisearchFilter
{
    protected $column = 'performers';

    public function formatValue()
    {
        $screenName = ScreenName::where('screen_name', $this->value)->firstOrFail();
        return implode(' ', [addslashes($screenName->screen_nameable_type), $screenName->screen_nameable_id]);
    }
}
