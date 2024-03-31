<?php

namespace App\Http\Controllers\Follow;

use App\Http\Requests\FollowRequest;
use App\Services\UserService;

/**
 * フォロー関連の操作を管理するコントローラー
 */
class DestroyFollowController extends FollowBaseController
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

    public function __invoke(FollowRequest $request)
    {
        $result = $this->userService->unfollowByFollowable(auth()->user(), $request->type, $request->id);

        return $this->generateResponse($result['message'], $result['unfollowed']);
    }
}
