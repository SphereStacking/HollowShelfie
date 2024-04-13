<?php

namespace App\Http\Controllers\Profile;

use App\Models\User;
use Inertia\Inertia;
use App\Services\UserService;
use App\Params\EventSearchParams;
use App\Http\Controllers\Controller;
use App\Services\EventMeilisearchService;
use App\Http\Resources\EventsPaginatedJsonResource;
use App\Http\Resources\UserPublicProfileJsonResource;

class GetUserProfileController extends Controller
{
    public function __construct(
        private UserService $userService,
        private EventMeilisearchService $eventMeilisearchService
    ) {}


    /**
     * ユーザーのプロファイルを表示します。
     */
    public function __invoke(User $user)
    {
        // User モデルのルートモデルバインディングを使用してユーザーを取得
        // ユーザープロファイルのビューを返す
        $EventSearchParams = new EventSearchParams(
            '',
            [['include' => 'and', 'type' => 'user', 'value' => $user->name]],
            12,
            'new',
        );

        return Inertia::render('User/Index', [
            'profile' => new UserPublicProfileJsonResource(
                $this->userService->preloadProfileData($user),
            ),
            'events' => new EventsPaginatedJsonResource(
                $this->eventMeilisearchService->getPublishedEventSearch($EventSearchParams)
            ),
            'url' => route('event.search.index', [
                't' => $EventSearchParams->text,
                'q' => $EventSearchParams->queryParams,
                'paginate' => $EventSearchParams->getDefaultPaginate(),
                'o' => $EventSearchParams->order,
            ]),
        ]);
    }
}
