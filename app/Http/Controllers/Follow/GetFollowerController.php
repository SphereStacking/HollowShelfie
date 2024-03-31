<?php

namespace App\Http\Controllers\Follow;

use App\Http\Resources\FollowPaginatedResource;
use App\Services\UserService;
use Inertia\Inertia;

/**
 * フォロー関連の操作を管理するコントローラー
 */
class GetFollowerController extends FollowBaseController
{
    protected $userService;

    /**
     * FollowControllerのコンストラクタ
     */
    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    public function __invoke()
    {
        return Inertia::render('Dashboard/Follow', [
            'follows' => new FollowPaginatedResource(
                $this->userService->getFollowPagination(auth()->user(), 10)
            )]
        );
    }
}
