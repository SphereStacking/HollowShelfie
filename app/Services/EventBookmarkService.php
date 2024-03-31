<?php
namespace App\Services;

use App\Models\User;
use App\Models\Event;
use App\Enums\EventStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * イベントブックマークサービスクラス
 */
class eventBookmarkService
{
    /**
     * ユーザーがイベントをブックマークする
     *
     * @param User $user
     * @param Event $event
     */
    public function attachEvent(User $user, Event $event)
    {
        if (!$this->isEventBookmarkedByUser($user, $event)) {
            $user->bookmark_events()->attach($event->id);
        }
    }

    /**
     * ユーザーがイベントのブックマークを解除する
     *
     * @param User $user
     * @param Event $event
     */
    public function detachEvent(User $user, Event $event)
    {
        $user->bookmark_events()->detach($event->id);
    }

    /**
     * ユーザーがブックマークしたイベントを取得する
     *
     * @param User $user
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getBookmarkedEventsByUser(User $user)
    {
        return $user->bookmark_events()->paginate(12);
    }

    /**
     * ユーザーがブックマークしたイベントの数を取得する
     *
     * @param User $user
     * @return int
     */
    public function getBookmarkedEventsCountByUser(User $user)
    {
        return  $user->bookmark_events()->count();
    }

    /**
     * ユーザーがブックマークした各ステータスのイベントの数を取得する
     *
     * @param User $user
     * @return array
     */
    public function getBookmarkedEventsCountByUserForAllStatuses(User $user)
    {
        $counts = [];
        foreach (EventStatus::cases() as $status) {
            $counts[$status] = $user->bookmark_events()->where('status', $status)->count();
        }
        return $counts;
    }

    /**
     * ユーザーが特定のイベントをブックマークしているか確認する
     *
     * @param User $user
     * @param Event $event
     * @return bool
     */
    public function isEventBookmarkedByUser(User $user, Event $event)
    {
        // ユーザーが特定のイベントをブックマークしているか確認
        return $user->bookmark_events()->where('event_id', $event->id)->exists();
    }
}
