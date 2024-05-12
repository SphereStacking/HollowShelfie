<?php

namespace App\Services;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * イベントブックマークサービスクラス
 */
class EventBookmarkService
{
    /**
     * ユーザーがイベントをブックマークする
     */
    public function attachEvent(User|Authenticatable|null $user, Event $event): void
    {
        if (! $this->isEventBookmarkedByUser($user, $event)) {
            $user->bookmark_events()->attach($event->id);
        }
    }

    /**
     * ユーザーがイベントのブックマークを解除する
     */
    public function detachEvent(User|Authenticatable|null $user, Event $event)
    {
        $user->bookmark_events()->detach($event->id);
    }

    /**
     * ユーザーがブックマークしたイベントを取得する
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getBookmarkedEventsByUser(User|Authenticatable|null $user)
    {
        return $user->bookmark_events()->paginate(12);
    }

    /**
     * ユーザーがブックマークしたイベントの数を取得する
     *
     * @return int
     */
    public function getBookmarkedEventsCountByUser(User|Authenticatable|null $user)
    {
        return $user->bookmark_events()->count();
    }

    /**
     * ユーザーが特定のイベントをブックマークしているか確認する
     *
     * @return bool
     */
    public function isEventBookmarkedByUser(User|Authenticatable|null $user, Event $event)
    {
        // ユーザーが特定のイベントをブックマークしているか確認
        return $user->bookmark_events()->where('event_id', $event->id)->exists();
    }
}
