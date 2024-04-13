<?php

namespace App\Traits;

use App\Models\Team;
use App\Models\User;
use App\Models\Followable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasFollowable
{
    /**
     * ログインUserがフォローしているか
     */
    public function getIsFollowedAttribute() : bool
    {
        return $this->isFollowedByCurrentUser();
    }

    /**
     * 対象modelのフォロー数
     */
    public function getFollowersCountAttribute()
    {
        return $this->followersCount();
    }


    /**
     * このモデルがフォローしているFollowableモデルのリレーションを返します。
     */
    public function follows():HasMany
    {
        return $this->hasMany(Followable::class, 'user_id');
    }

    /**
     * モデルにフォロー機能を追加します。
     */
    public function followables() : MorphMany
    {
        return $this->morphMany(Followable::class, 'followable');
    }

    /**
     * このモデルをフォローします。
     */
    public function follow(Model $followTarget): Followable
    {
        if (! Auth::check()) {
            throw new AuthenticationException('ログイン');
        }

        return Followable::firstOrCreate([
            'user_id' => $this->getKey(),
            'followable_id' => $followTarget->getKey(),
            'followable_type' => get_class($followTarget),
        ]);
    }

    /**
     * このモデルのフォローを解除します。
     *
     */
    public function unfollow(Model $unfollowTarget): bool|null
    {
        if (! Auth::check()) {
            throw new AuthenticationException('');
        }

        return Followable::where('user_id', $this->getKey())
            ->where('followable_id', $unfollowTarget->getKey())
            ->where('followable_type', get_class($unfollowTarget))
            ->delete();
    }

    /**
     * 指定されたユーザーによってこのモデルがフォローされているかどうかを確認します。
     */
    public function isFollowedBy(User $user)
    {
        return $this->followables()
            ->where('user_id', $user->getKey())
            ->exists();
    }

    /**
     * このモデルをフォローしているユーザーの数を取得します。
     */
    public function followersCount(): int
    {
        return $this->followables()->count();
    }


    /**
     * このモデルがフォローしている数を取得します。
     */
    public function followingCount(): int
    {
        return $this->follows()->count();
    }

    /**
     * 現在のユーザーがフォローしているがどうか
     */
    public function isFollowedByCurrentUser(): bool
    {
        // NOTE: 認証していないユーザーにはfalse
        if (! Auth::check()) {
            return false;
        }

        return Followable::where('user_id', Auth::id())
            ->where('followable_id', $this->getKey())
            ->where('followable_type', get_class($this))
            ->exists();
    }
}
