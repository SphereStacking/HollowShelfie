<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use Carbon\Carbon;
use App\Services\DynamicSearch\Meilisearch\MeilisearchFilter;

/**
 * Organizerクエリパラメータクラス
 */
class EventFilterOrganizer extends MeilisearchFilter
{
    protected $column = 'organizers';

    public function formatValue()
    {
        return $this->value;
    }
}
