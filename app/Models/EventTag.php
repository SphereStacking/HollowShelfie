<?php

namespace App\Models;

use DateTime;
use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Auth;

class EventTag extends Pivot
{
    /**
     * イベントタグに基づく集計クエリを取得。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopularTags()
    {
        return EventTag::select('tag_id')
            ->selectRaw('count(*) as count')
            ->groupBy('tag_id')
            ->orderByDesc('count');
    }
}
