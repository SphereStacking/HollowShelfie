<?php

namespace App\Services;

use App\Models\Tag;
use App\Models\Event;
use App\Models\Taggable;
use Illuminate\Support\Facades\DB;

class TagService
{
    public function getTrendTag($limit = 10)
    {
        return Tag::withCount('events')
            ->orderByDesc('events_count')
            ->limit($limit)
            ->get();
    }

    public function getTrendTagNames()
    {
        $popularTagIds = Taggable::where('taggable_type', Event::class)
            ->select('tag_id', DB::raw('COUNT(tag_id) as count'))
            ->groupBy('tag_id')
            ->orderByDesc('count')
            ->limit(4)
            ->pluck('tag_id');

        return Tag::whereIn('id', $popularTagIds)->pluck('name');
    }
}
