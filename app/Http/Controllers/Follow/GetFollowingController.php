<?php

namespace App\Http\Controllers\Follow;

use Inertia\Inertia;
use App\Services\UserService;
use App\Http\Resources\FollowPaginatedResource;

/**
 * フォロー関連の操作を管理するコントローラー
 */
class GetFollowingController extends FollowBaseController
{

    protected $userService;

    /**
     * FollowControllerのコンストラクタ
     *
     * @param UserService $userService
     */
    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    public function __invoke()
    {
        return Inertia::render('Dashboard/Follow',[
            'follows' =>  new FollowPaginatedResource(
                $this->userService->getFollowPagination(auth()->user(), 10)
            )]
        );
    }

}

