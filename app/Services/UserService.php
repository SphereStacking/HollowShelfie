<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * ユーザーサービスクラス
 */
class UserService
{
    /**
     * コンストラクタ
     */
    public function __construct(){}

    /**
     * フォローページネーションを取得する
     *
     * @param int $perPage
     */
    public function getFollowPagination(User $user, $perPage = 10)
    {
        $follows = $user->follows()->with('followable')->orderBy('created_at', 'desc')->paginate($perPage);

        foreach ($follows as $follow) {
            $followable = $follow->followable;
            $followable->is_followed = $followable->isFollowedByCurrentUser();
        }

        return $follows;
    }

    /**
     * フォロワーページネーションを取得する
     *
     * @param int $perPage
     */
    public function getFollowerPagination(User $user, $perPage = 10)
    {
        $followers = $user->followables()->with('user')->orderBy('created_at', 'desc')->paginate($perPage);

        foreach ($followers as $follower) {
            $followerUser = $follower->user;
            $followerUser->is_followed = $followerUser->isFollowedByCurrentUser();
        }

        return $followers;
    }

    /**
     * 対象のフォロー数を取得する
     *
     * @return int
     */
    public function getFollowCount(User $user)
    {
        return $user->followingCount();
    }

    /**
     * 対象のフォロワー数を取得する
     *
     * @return int
     */
    public function getFollowerCount(User $user)
    {
        return $user->followersCount();
    }

    public function follow(User $authUser, $model)
    {
        $authUser->follow($model);
        $message = "{$authUser->name}が{$model->name}をフォローしました。";

        return [
            'message' => $message,
            'following' => $authUser,
            'followed' => $model,
        ];
    }

    public function unfollow(User $authUser, $model)
    {
        $authUser->unfollow($model);
        $message = "{$authUser->name}が{$model->name}のフォローを解除しました。";

        return [
            'message' => $message,
            'following' => $authUser,
            'unfollowed' => $model,
        ];
    }



    public function getUserByTestScreenName(string $screenName) : User
    {
        return User::where('screen_name', $screenName)->firstOrFail();
    }
}
