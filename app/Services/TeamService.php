<?php

namespace App\Services;

use App\Models\Tag;
use Inertia\Inertia;
use App\Models\Event;
use App\Enums\EventStatus;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use App\Services\FileService;

class TeamService
{

    public function __construct()
    {
    }

    // 事前ロードする
    public function preloadProfileData(Team $team)
    {
        $team->load(['links', 'event_organizers']);
        $team->is_followed = $team->isFollowedByCurrentUser();
        $team->followers_count = $team->followersCount();
        return $team;
    }
}
