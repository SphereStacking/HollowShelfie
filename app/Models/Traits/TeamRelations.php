<?php

namespace App\Models\Traits;

use App\Models\Tag;
use App\Models\Link;
use App\Models\User;
use App\Models\EventOrganizer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * ユーザー関連のトレイト
 */
trait TeamRelations
{
    /**
     * このTeamのイベントオーガナイザー取得
     */
    public function event_organizers(): MorphMany
    {
        return $this->morphMany(EventOrganizer::class, 'event_organizeble');
    }

    /**
     * リンク取得
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

    /**
     * メンバー取得
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * メンバー取得
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
