<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\FollowRequest;
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

    public function following()
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

    public function follow(FollowRequest $request)
    {
        $result = $this->userService->followByFollowable(auth()->user(),$request->type,$request->id);
        return $this->generateResponse($result['message'] , $result['followed']);
    }

    public function unfollow(FollowRequest $request)
    {
        $result = $this->userService->unfollowByFollowable(auth()->user(), $request->type,$request->id);
        return $this->generateResponse($result['message'] , $result['unfollowed']);
    }

    /**
     * ユーザーをフォローします。
     *
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function followUser(User $user)
    {
        $result = $this->userService->follow(auth()->user(),$user);
        return $this->generateResponse($result['message'] , $result['followed']);
    }

    /**
     * 指定されたユーザーのフォローを解除します。
     *
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function unfollowUser(User $user)
    {
        $result = $this->userService->unfollow(auth()->user(),$user);

        return $this->generateResponse($result['message'] , $result['unfollowed']);
    }

    /**
     * 指定されたチームをフォローします。
     *
     * @param  Team  $team
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function followTeam(Team $team)
    {
        $result = $this->userService->follow(auth()->user(),$team);
        return $this->generateResponse($result['message'] , $result['followed']);
    }

    /**
     * 指定されたチームのフォローを解除します。
     *
     * @param  Team  $team
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function unfollowTeam(Team $team)
    {
        $result =$this->userService->unfollow(auth()->user(),$team);

        return $this->generateResponse($result['message'] , $result['unfollowed']);
    }
}

