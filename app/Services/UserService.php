<?php

namespace App\Services;

use App\Models\User;

/**
 * ユーザーサービスクラス
 */
class UserService
{
    protected $eventMeilisearchService;

    /**
     * コンストラクタ
     */
    public function __construct(EventMeilisearchService $eventMeilisearchService)
    {
        $this->eventMeilisearchService = $eventMeilisearchService;
    }

    /**
     * プロフィールデータを事前ロードする
     */
    public function preloadProfileData(User $user): User
    {
        // $user->links();
        // $user->tags();
        return $user;
    }

    /**
     * フォローページネーションを取得する
     *
     * @param  int  $perPage
     * @return mixed
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
     * @param  int  $perPage
     * @return mixed
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

    public function followByFollowable(User $authUser, $type, $id)
    {
        $model = $type::find($id);

        return $this->follow($authUser, $model);
    }

    public function unfollowByFollowable(User $authUser, $type, $id)
    {
        $model = $type::find($id);

        return $this->unfollow($authUser, $model);
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
}
