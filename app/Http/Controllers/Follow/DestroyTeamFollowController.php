<?php

namespace App\Http\Controllers\Follow;

use App\Models\Team;
use App\Services\UserService;

/**
 * フォロー関連の操作を管理するコントローラー
 */
class DestroyTeamFollowController extends FollowBaseController
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

    public function __invoke(Team $team)
    {
        $result = $this->userService->unfollow(auth()->user(), $team);

        return $this->generateResponse($result['message'], $result['unfollowed']);
    }
}
