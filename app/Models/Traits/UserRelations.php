<?php

namespace App\Models\Traits;

use App\Models\Tag;
use App\Models\File;
use App\Models\Link;
use App\Models\User;
use App\Models\View;
use App\Models\Badge;
use App\Models\Event;
use App\Models\Category;
use App\Models\Instance;
use App\Models\SocialAccount;
use App\Models\EventOrganizer;
use App\Models\EventTimeTable;

/**
 * ユーザー関連のトレイト
 */
trait UserRelations
{
    /**
     * 外部認証アカウントリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function social_accounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * ブックマークイベントリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bookmark_events()
    {
        return $this->belongsToMany(Event::class, 'event_user_bookmark');
    }

    /**
     * グッドイベントリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function good_events()
    {
        return $this->belongsToMany(Event::class, 'event_user_good');
    }

    /**
     * このUserがオーガナイザーしているイベントを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function event_organizers()
    {
        return $this->morphMany(EventOrganizer::class, 'event_organizeble');
    }

    /**
     * リンクリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function links()
    {
        return $this->morphMany(Link::class, 'linkable');
    }

    /**
     * フォロー機能 Userがフォローしている人
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function follows()
    {
        return $this->morphToMany(User::class, 'followable', 'follows', 'user_id', 'followable_id');
    }

    /**
     * フォロー機能 Userをfollowしている人
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function followers()
    {
        return $this->morphToMany(User::class, 'followable', 'follows')->withTimestamps();
    }
    /**
     * ユーザーのフォロワー数を取得する
     *
     * @return int
     */
    public function followersCount()
    {
        return $this->followers()->count();
    }

    /**
     * このユーザーがフォローしている人数を取得する
     *
     * @return int
     */
    public function followingsCount()
    {
        return $this->followings()->count();
    }

    /**
     * 認証してるユーザーがフォローしているがどうか
     * 認証されていなければ falseを返す
     *
     * @return bool
     */
    public function isFollowed()
    {
        if (!auth()->check()) {
            return false;
        }
        return $this->followers()->where('user_id', auth()->id())->exists();
    }

    /**
     * バッジリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function badges()
    {
        return $this->morphToMany(Badge::class, 'badgeable');
    }
}
