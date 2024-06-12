<?php

namespace App\Http\Controllers\Follow;

use App\Models\ScreenName;
use App\Services\UserService;
use App\Http\Requests\FollowRequest;

/**
 * フォロー関連の操作を管理するコントローラー
 */
class StoreFollowController extends FollowBaseController
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
        $result = $this->userService->follow(auth()->user(),$screenName->screenNameable);

        return $this->generateResponse($result['message'], $result['followed']);
    }
}
