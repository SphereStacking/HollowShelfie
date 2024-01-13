<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\FollowPaginatedResource;
use App\Http\Resources\FollowablePaginatedResource;

/**
 * フォロー関連の操作を管理するコントローラー
 */
class FollowController extends Controller
{

    protected $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }
    public function follow()
    {
        return Inertia::render(
            'Dashboard/Follow',
            [
                'follows' =>  new FollowPaginatedResource(
                    $this->userService->getFollowPagination(auth()->user(), 10)
                )
            ]
        );
    }

    public function follower()
    {
        return Inertia::render(
            'Dashboard/Follower',
            [
                'followers' => new FollowablePaginatedResource(
                    $this->userService->getFollowerPagination(auth()->user(), 10)
                )
            ]
        );
    }

    /**
     * レスポンスを生成します。
     *
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    private function generateResponse($message,$target)
    {
        if (request()->wantsJson()) {
            // Ajaxリクエストの場合はJSONレスポンスを返す
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'is_followed' => $target->isFollowedByCurrentUser(),
                'followers_count' => $target->followersCount()
            ]);
        } else {
            // それ以外の場合はInertiaレスポンス（またはリダイレクト）を返す
            return Redirect::back()->with([
                'status' => 'success',
                'message' => $message
            ]);
        }
    }

    /**
     * ユーザーをフォローします。
     *
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function followUser(User $user)
    {
        $authUser = auth()->user();
        $authUser->follow($user);
        $message = "{$authUser->name}さんが{$user->name}をフォローしました。";

        return $this->generateResponse($message,$user);
    }

    /**
     * 指定されたユーザーのフォローを解除します。
     *
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function unfollowUser(User $user)
    {
        $authUser = auth()->user();
        $authUser->unfollow($user);
        $message = "{$authUser->name}さんが{$user->name}のフォローを解除しました。";

        return $this->generateResponse($message,$user);
    }

    /**
     * 指定されたチームをフォローします。
     *
     * @param  Team  $team
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function followTeam(Team $team)
    {
        $authUser = auth()->user();
        $authUser->follow($team);
        $message = "{$authUser->name}さんが{$team->name}をフォローしました。";

        return $this->generateResponse($message,$team);
    }

    /**
     * 指定されたチームのフォローを解除します。
     *
     * @param  Team  $team
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function unfollowTeam(Team $team)
    {
        $authUser = auth()->user();
        $authUser->unfollow($team);
        $message = "{$authUser->name}さんが{$team->name}のフォローを解除しました。";

        return $this->generateResponse($message,$team);
    }
}

