<?php

namespace App\Services;

use App\Models\Tag;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\EventTag;
use App\Enums\EventStatus;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use App\Services\FileService;

class TeamService
{

    public function __construct()
    {
    }

    //公開情報を取得する
    public function getPublishProfile($id)
    {
        return Team::with('events')->find($id);
    }
}
