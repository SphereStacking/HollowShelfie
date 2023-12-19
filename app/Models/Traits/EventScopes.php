<?php

namespace App\Models\Traits;

use App\Enums\EventStatus;

/**
 * イベントのスコープに関するトレイト
 */
trait EventScopes
{
    /**
     * 公開中のイベントを取得するスコープ
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatusPublished($query)
    {
        return $query->whereIn(
            'status',
            [
                EventStatus::ONGOING,
                EventStatus::UPCOMING,
                EventStatus::CLOSED
            ]
        );
    }

    /**
     * Scout用の公開中のイベントを取得するスコープ
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatusPublishedForScout($query)
    {
        return $query->whereIn(
            'status',
            [
                EventStatus::ONGOING->name,
                EventStatus::UPCOMING->name,
                EventStatus::CLOSED->name
            ]
        );
    }

    /**
     * 新しいイベントを取得するスコープ
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByNewest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Scout用 良い評価の多いイベントを取得するスコープ
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByGoodUserCountForScout($query)
    {
        return $query->orderBy('good_count', 'desc');
    }
    /**
     * 良い評価の多いイベントを取得するスコープ
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByGoodUserCount($query)
    {
        return $query->withCount('good_users')->orderBy('good_users_count', 'desc');
    }

    /**
     *閲覧数なイベントを取得するスコープ
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByViews($query)
    {
        return $query->orderBy('hot', 'desc');
    }

    /**
     * トレンドのイベントを取得するスコープ
     * TODO: いつか実装
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByTrendiness($query)
    {
        return $query;
    }

    /**
     * タグに基づいてフィルタするクエリスコープ
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $tags
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterByTags($query, $tags)
    {
        if ($tags) {
            // タグの名前で絞り込む
            $query->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('name', $tags);
            });
        }
        return $query;
    }
}
