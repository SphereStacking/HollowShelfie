<?php

namespace App\Http\Controllers\Follow;

use App\Models\Team;
use App\Models\ScreenName;
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

    public function __invoke($screenName)
    {
        $screenName = ScreenName::findScreenNameable($screenName);
        $result = $this->userService->unfollow(auth()->user(), $screenName->screen_nameable);

        return $this->generateResponse($result['message'], $result['unfollowed']);
    }
}
