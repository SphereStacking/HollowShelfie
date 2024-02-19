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
     * グッドイベントリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function create_events()
    {
        return $this->hasMany(Event::class, 'event_create_user_id');
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
     * バッジリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function badges()
    {
        return $this->morphToMany(Badge::class, 'badgeable');
    }

    /**
     * タグとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
