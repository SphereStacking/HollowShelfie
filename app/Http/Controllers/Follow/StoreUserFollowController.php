<?php

namespace App\Http\Controllers\Follow;

use App\Models\User;
use App\Services\UserService;

/**
 * フォロー関連の操作を管理するコントローラー
 */
class StoreUserFollowController extends FollowBaseController
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

    public function __invoke(User $user)
    {
        $result = $this->userService->follow(auth()->user(),$user);
        return $this->generateResponse($result['message'] , $result['followed']);
    }

}

