<?php

namespace App\Services;

use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class EventGoodService
{
    public function attachEvent(User $user, Event $event)
    {
        if (!$this->isEventGoodByUser($user, $event)) {
            $user->good_events()->attach($event->id);
        }
    }

    public function detachEvent(User $user, Event $event)
    {
        $user->good_events()->detach($event->id);
    }

    public function getGoodEventsByUser(User $user)
    {
        return $user->good_events()->paginate(12);
    }

    public function getGoodEventsCountByUser(User $user)
    {
        return $user->good_events()->count();
    }

    public function isEventGoodByUser(User $user, Event $event)
    {
        // ユーザーが特定のイベントをいいねしているか確認
        return $user->good_events()->where('event_id', $event->id)->exists();
    }
}
