<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use App\Models\ScreenName;
use App\Services\DynamicSearch\Meilisearch\MeilisearchFilter;

/**
 * Organizerクエリパラメータクラス
 */
class EventFilterOrganizer extends MeilisearchFilter
{
    protected $column = 'organizers';

    public function formatValue()
    {
        $screenName = ScreenName::where('screen_name', $this->value)->firstOrFail();
        return implode(' ', [addslashes($screenName->screen_nameable_type), $screenName->screen_nameable_id]);
    }
}
