<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use App\Models\User;
use App\Services\DynamicSearch\Meilisearch\MeilisearchFilter;

/**
 * Organizerクエリパラメータクラス
 */
class EventFilterOrganizer extends MeilisearchFilter
{
    protected $column = 'organizer_ids';

    public function formatValue()
    {
        return User::where('name', $this->value)->value('id');
    }
}
