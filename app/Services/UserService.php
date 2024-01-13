<?php

namespace App\Services;

use App\Models\User;
use App\Services\EventMeilisearchService;

/**
 * ユーザーサービスクラス
 */
class UserService
{
    protected $eventMeilisearchService;

    /**
     * コンストラクタ
     * @param EventMeilisearchService $eventMeilisearchService
     */
    public function __construct(EventMeilisearchService $eventMeilisearchService)
    {
        $this->eventMeilisearchService = $eventMeilisearchService;
    }

    /**
     * プロフィールデータを事前ロードする
     * @param User $user
     * @return User
     */
    public function preloadProfileData(User $user)
    {
        $user->load(['links', 'tags']);
        $user->is_followed = auth()->user()->isFollowedByCurrentUser();
        $user->followers_count = $user->followersCount();
        return $user;
    }

    /**
     * フォローページネーションを取得する
     * @param User $user
     * @param int $perPage
     * @return mixed
     */
    public function getFollowPagination(User $user, $perPage = 10)
    {
        $follows = $user->follows()->with('followable')->orderBy('created_at', 'desc')->paginate($perPage);

        // 各フォロー対象が認証ユーザーによってフォローされているかを確認
        foreach ($follows as $follow) {
            $followable = $follow->followable;
            $followable->is_followed = $followable->isFollowedByCurrentUser();
        }

        return $follows;
    }

    /**
     * フォロワーページネーションを取得する
     * @param User $user
     * @param int $perPage
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
     * @param User $user
     * @return int
     */
    public function getFollowCount(User $user)
    {
        return $user->followingCount();
    }

    /**
     * 対象のフォロワー数を取得する
     * @param User $user
     * @return int
     */
    public function getFollowerCount(User $user)
    {
        return $user->followersCount();
    }

}
