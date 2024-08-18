<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Services\DynamicSearch\Meilisearch\MeilisearchArrayFilter;

/**
 * ログインユーザーがフォローしているユーザーのイベントを検索する
 */
class EventFilterFollow extends MeilisearchArrayFilter
{
    protected $column = 'organizers';

    private function sanitizeColumn(){
        return match ($this->value) {
            'organizers' => 'organizers',
            'performers' => 'performers',
            default => 'organizers',
        };
    }

    /**
     */
    public function formatValue(): Collection
    {
        $this->column = $this->sanitizeColumn();

        $user = Auth::user();
        if (!$user) {
            return collect();
        }
        $follows = $user->follows->map(function ($follow) {
            return  implode(' ', [$follow->followable_type, $follow->followable_id]);
        });
        return $follows;
    }
}
