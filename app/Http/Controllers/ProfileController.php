<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\TeamService;
use App\Services\UserService;

class ProfileController extends Controller
{
    protected $userService;
    protected $teamService;

    public function __construct(
        UserService $userService,
        TeamService $teamService,
    ) {
        $this->userService = $userService;
        $this->teamService = $teamService;
    }

    //
        /**
     * ユーザーのプロファイルを表示します。
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function userProfileShow($id)
    {
        // User モデルのルートモデルバインディングを使用してユーザーを取得
        // ユーザープロファイルのビューを返す
        return Inertia::render('User/Index', [
            'profile' => $this->userService->getPublishProfile($id)
        ]);
    }

    /**
     * チームのプロファイルを表示します。
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\View\View
     */
    public function teamProfileShow($id)
    {
        // Team モデルのルートモデルバインディングを使用してチームを取得
        // チームプロファイルのビューを返す
        return Inertia::render('PublishProfile/Team', [
            'profile'=> $this->teamService->getPublishProfile($id)
        ]);
    }
}
