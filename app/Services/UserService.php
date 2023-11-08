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
        return User::with([
            'links',          // ユーザーに関連するリンク
            'event_organizers' // ユーザーがオーガナイザーとなっているイベント
        ])
            ->find($id);
    }
}
