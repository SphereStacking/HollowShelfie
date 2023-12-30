<?php
namespace App\Services;

use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class EventGoodService
{
    public function attachEvent(User $user, Event $event)
    {
        $user->good_events()->attach($event->id);
    }

    public function detachEvent(User $user, Event $event)
    {
        $user->good_events()->detach($event->id);
    }
}
