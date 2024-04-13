<?php

namespace App\Models\Traits;

use App\Models\Tag;
use App\Models\Link;
use App\Models\Badge;
use App\Models\EventOrganizer;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
     * バッジリレーション
     */
    public function badges(): MorphToMany
    {
        return $this->morphToMany(Badge::class, 'badgeable');
    }

    /**
     * タグとのリレーション
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
