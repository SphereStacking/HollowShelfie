<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use App\Models\InstanceType;
use App\Services\DynamicSearch\Meilisearch\MeilisearchFilter;

/**
 * instanceクエリパラメータクラス
 */
class EventFilterInstance extends MeilisearchFilter
{
    protected $column = 'instance_type_ids';

    public function formatValue()
    {
        return InstanceType::where('name', $this->value)->value('id');
    }
}
