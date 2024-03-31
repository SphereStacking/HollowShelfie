<?php

namespace App\Services;

use App\Models\Team;

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
