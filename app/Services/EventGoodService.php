<?php

namespace App\Services;

use App\Models\User;
use App\Models\Event;
use \Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventGoodService
{
    public function attachEvent(User| Authenticatable | null $user, Event $event): void
    {
        if (! $this->isEventGoodByUser($user, $event)) {
            $user->good_events()->attach($event->id);
        }
    }

    public function detachEvent(User| Authenticatable | null $user, Event $event): bool
    {
        return $user->good_events()->detach($event->id);
    }

    public function getGoodEventsByUser(User| Authenticatable | null $user): LengthAwarePaginator
    {
        return $user->good_events()->paginate(12);
    }

    public function getGoodEventsCountByUser(User| Authenticatable | null $user) : int
    {
        return $user->good_events()->count();
    }

    public function isEventGoodByUser(User| Authenticatable | null $user, Event $event) : bool
    {
        // ユーザーが特定のイベントをいいねしているか確認
        return $user->good_events()->where('event_id', $event->id)->exists();
    }
}
