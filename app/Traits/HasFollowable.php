<?php

namespace App\Traits;

use App\Models\Followable;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait HasFollowable
{
    /**
     * このモデルがフォローしているFollowableモデルのリレーションを返します。
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function follows()
    {
        return $this->hasMany(Followable::class, 'user_id');
    }

    /**
     * モデルにフォロー機能を追加します。
     */
    public function followables()
    {
        return $this->morphMany(Followable::class, 'followable');
    }

    /**
     * このモデルをフォローします。
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function follow($followTarget)
    {
        if (! Auth::check()) {
            return;
        }

        return Followable::firstOrCreate([
            'user_id' => $this->id,
            'followable_id' => $followTarget->id,
            'followable_type' => get_class($followTarget),
        ]);
    }

    /**
     * このモデルのフォローを解除します。
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function unfollow($unfollowTarget)
    {
        if (! Auth::check()) {
            return;
        }

        return Followable::where('user_id', $this->id)
            ->where('followable_id', $unfollowTarget->id)
            ->where('followable_type', get_class($unfollowTarget))
            ->delete();
    }

    /**
     * 指定されたユーザーによってこのモデルがフォローされているかどうかを確認します。
     */
    public function isFollowedBy(User $user)
    {
        return $this->followables()
            ->where('user_id', $user->id)
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
     * 認証してるユーザーがフォローしているがどうか
     * 認証されていなければ falseを返す
     */
    public function isFollowedByCurrentUser(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        return Followable::where('user_id', auth()->id())
            ->where('followable_id', $this->id)
            ->where('followable_type', get_class($this))
            ->exists();
    }
}
