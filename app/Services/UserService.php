<?php

namespace App\Services;

use App\Models\Tag;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Event;
use App\Enums\EventStatus;
use App\Services\FileService;
use App\Params\EventSearchParams;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\EventMeilisearchService;
use App\Http\Resources\EventListJsonResource;

class UserService
{
    protected $eventMeilisearchService;

    public function __construct(EventMeilisearchService $eventMeilisearchService)
    {
        $this->eventMeilisearchService = $eventMeilisearchService;
    }

    // 事前ロードする
    public function preloadProfileData(User $user)
    {
        $user->load(['links', 'tags']);
        $user->is_followed = $user->isFollowed();
        return $user;
    }
}
