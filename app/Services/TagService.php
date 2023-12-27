<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    public function getTrendTag($limit = 10)
    {
        return Tag::withCount('events')
            ->orderByDesc('events_count')
            ->limit($limit)
            ->get();
    }
}
