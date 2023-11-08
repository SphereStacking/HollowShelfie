<?php

namespace App\Services;

use App\Models\Tag;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\EventTag;
use App\Enums\EventStatus;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;

class UserService
{

    public function __construct()
    {
    }

    // Userの公開情報を返す
    public function getPublishProfile($id)
    {
        $user = User::find($id);
        $user->load('links');

        $user->events_organized = $user->event_organizers()
            ->whereHas('event', function ($query) {
                $query->whereIn('status', [EventStatus::ONGOING, EventStatus::UPCOMING]);
            })
            ->with('event')
            ->take(4)
            ->get()
            ->pluck('event');
        return $user;
    }
}
