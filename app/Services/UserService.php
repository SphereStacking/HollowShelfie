<?php

namespace App\Services;

use App\Models\Tag;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\EventTag;
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
    public function getPublishProfile($id)
    {
        $user = User::find($id);
        $EventSearchParams = new EventSearchParams(
            '',
            [['include' => 'and', 'type' => 'user', 'value' => $user->name]],
            4,
            'new',
        );
        $user = User::find($id);
        $user->load('links');
        $user->events = $this->eventMeilisearchService->getPublishedEventSearch($EventSearchParams);
        Log::debug($user->events);
        return $user;
    }
}
