<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getTrendCategories($limit = 10)
    {
        return Category::withCount('events')
            ->orderByDesc('events_count')
            ->limit($limit)
            ->get();
    }
}
