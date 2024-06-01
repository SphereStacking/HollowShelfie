<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use Illuminate\Support\Facades\Auth;
use App\Services\DynamicSearch\Meilisearch\MeilisearchSystemFilter;

/**
 * Event作成者クエリパラメータクラス
 */
class EventSystemFilterCreaterById extends MeilisearchSystemFilter
{
    public function makeQuery()
    {
        return 'created_user_id = '. Auth::user()->id;
    }
}
