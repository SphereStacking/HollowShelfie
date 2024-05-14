<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use App\Models\User;
use App\Services\DynamicSearch\Meilisearch\MeilisearchFilter;

/**
 * Performerクエリパラメータクラス
 */
class EventFilterPerformer extends MeilisearchFilter
{
    protected $column = 'performer_ids';

    public function formatValue()
    {
        return User::where('name', $this->value)->value('id');
    }
}
