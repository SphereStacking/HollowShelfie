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

    // Userの公開情報を返す
    public function getPublishProfile($id): User
    {
        $user = User::find($id);
        $user->load('links');
        $user->is_followed = $user->isFollowed();
        return $user;
    }
}
