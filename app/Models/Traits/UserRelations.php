<?php

namespace App\Models\Traits;

use App\Models\Tag;
use App\Models\Link;
use App\Models\Event;
use App\Models\Pickup;
use App\Models\SocialAccount;
use App\Models\EventOrganizer;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * ユーザー関連のトレイト
 */
trait UserRelations
{
    /**
     * 外部認証アカウントリレーション
     */
    public function social_accounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * ブックマークイベントリレーション
     */
    public function bookmark_events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_user_bookmark');
    }

    /**
     * グッドイベントリレーション
     */
    public function good_events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_user_good');
    }

    /**
     * グッドイベントリレーション
     */
    public function create_events(): HasMany
    {
        return $this->hasMany(Event::class, 'created_user_id');
    }

    /**
     * このUserがオーガナイザーしているイベントを取得
     */
    public function event_organizers(): MorphMany
    {
        return $this->morphMany(EventOrganizer::class, 'event_organizeble');
    }

    /**
     * リンクリレーション
     */
    public function links(): MorphMany
    {
        return $this->morphMany(Link::class, 'linkable');
    }

    /**
     * タグとのリレーション
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function pickups()
    {
        return $this->morphMany(Pickup::class, 'pickupable');
    }
}
