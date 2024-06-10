<?php

namespace App\Http\Controllers\Follow;

use App\Models\User;
use App\Models\ScreenName;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;

/**
 * フォロー関連の操作を管理するコントローラー
 */
class StoreUserFollowController extends FollowBaseController
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
