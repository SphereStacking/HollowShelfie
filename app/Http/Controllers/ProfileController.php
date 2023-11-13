<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\TeamService;
use App\Services\UserService;
use App\Http\Resources\UserPublicProfileJsonResource;

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
            'profile' => new UserPublicProfileJsonResource(
                $this->userService->getPublishProfile($id),
            ),
        ]);
    }

    public function adminProfileShow()
    {
        return Inertia::render('Home', [
            'adminUser' => new UserPublicProfileJsonResource(
                $this->userService->getPublishProfile(1),
            ),
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
        return Inertia::render('Team/Index', [
            'profile' => $this->teamService->getPublishProfile($id)
        ]);
    }
}
