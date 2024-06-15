<?php

namespace App\Http\Controllers\Profile;

use Inertia\Inertia;
use App\Models\ScreenName;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventsPaginatedJsonResource;
use App\Http\Resources\TeamPublicProfileJsonResource;
use App\Http\Resources\UserPublicProfileJsonResource;
use App\Services\DynamicSearch\Meilisearch\SearchParams;
use App\Services\DynamicSearch\Meilisearch\Event\EventMeilisearchService;

class EditUserProfileController extends Controller
{
    public function __construct(
        private EventMeilisearchService $eventMeilisearchService
    ) {}

    /**
     * ユーザーのプロファイルを表示します。
     */
    public function __invoke($screen_name)
    {
        $screenNameable = ScreenName::findScreenNameable($screen_name);
        $user = $screenNameable->user()->first();

        if (Auth::user()->id !== $user->id ) {
            return abort(403, '他人のプロフィールは編集できません!');
        }

        return Inertia::render('Profile/Edit', [
            'profile' =>  new UserPublicProfileJsonResource($screenNameable->screenNameable->load('tags', 'links')),
        ]);
    }
}
