<?php
namespace App\Traits;

use App\Models\User;
use App\Models\Followable;
use Illuminate\Support\Facades\Auth;

trait HasFollowable
{

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
    public function follow($model)
    {
        if (!Auth::check()) {
            return;
        }
        return $this->followables()->create([
            'user_id' =>  Auth::user()->id,
            'followable_id' => $model->getKey(),
            'followable_type' => get_class($model)
        ]);
    }

    /**
     * このモデルのフォローを解除します。
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function unfollow($model)
    {
        if (!Auth::check()) {
            return;
        }

        return $this->followables()
                    ->where('user_id', Auth::id())
                    ->where('followable_id', $model->getKey())
                    ->where('followable_type', get_class($model))
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
     *
     * @return int
     */
    public function followersCount(): int
    {
        return $this->followables()->count();
    }

    /**
     * このモデルがフォローしている数を取得します。
     *
     * @return int
     */
    public function followingCount(): int
    {
        return $this->follows()->count();
    }

    /**
     * 認証してるユーザーがフォローしているがどうか
     * 認証されていなければ falseを返す
     *
     * @return bool
     */
    public function isFollowed(): bool
    {
        if (!auth()->check()) {
            return false;
        }
        return $this->followables()
            ->where('user_id', auth()->id())
            ->exists();
    }

}

