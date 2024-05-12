<?php

namespace App\Models\Traits;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Laravel\Scout\Builder as ScoutBuilder;

/**
 * イベントのスコープに関するトレイト
 */
trait EventScopes
{

    /**
     * 新しいイベントを取得するスコープ
     */
    public function scopeOrderByNewest(EloquentBuilder|ScoutBuilder $query): EloquentBuilder|ScoutBuilder
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Scout用 良い評価の多いイベントを取得するスコープ
     */
    public function scopeOrderByGoodUserCountForScout(ScoutBuilder $query): ScoutBuilder
    {
        return $query->orderBy('good_count', 'desc');
    }

    /**
     * 良い評価の多いイベントを取得するスコープ
     */
    public function scopeOrderByGoodUserCount(EloquentBuilder|ScoutBuilder $query): EloquentBuilder|ScoutBuilder
    {
        return $query->withCount('good_users')->orderBy('good_users_count', 'desc');
    }

    /**
     * 閲覧数なイベントを取得するスコープ
     */
    public function scopeOrderByViews(EloquentBuilder|ScoutBuilder $query): EloquentBuilder|ScoutBuilder
    {
        return $query->orderBy('hot', 'desc');
    }

    /**
     * トレンドのイベントを取得するスコープ
     */
    public function scopeOrderByTrendiness(EloquentBuilder|ScoutBuilder $query): EloquentBuilder|ScoutBuilder
    {
        return $query;
    }

    /**
     * タグに基づいてフィルタするクエリスコープ
     */
    public function scopeFilterByTags(EloquentBuilder|ScoutBuilder $query, array $tags): EloquentBuilder|ScoutBuilder
    {
        if ($tags) {
            // タグの名前で絞り込む
            $query->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('name', $tags);
            });
        }

        return $query;
    }

    /**
     * ログイン中のユーザーが管理できるイベントのみを取得するスコープ。
     */
    public function scopeManagedByUser(EloquentBuilder|ScoutBuilder $query, int $userId): EloquentBuilder|ScoutBuilder
    {
        return $query->whereHas('organizers', function (EloquentBuilder|ScoutBuilder $query) use ($userId) {
            $query->where('user_id', $userId);
        });
    }
}
