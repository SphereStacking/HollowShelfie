<?php
namespace App\Services;

use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class eventBookmarkService
{
    public function attachEvent(User $user, Event $event)
    {
        $user->bookmark_events()->attach($event->id);
    }

    public function detachEvent(User $user, Event $event)
    {
        $user->bookmark_events()->detach($event->id);
    }
}
