<?php

namespace App\Models\Traits;

use App\Models\EventOrganizer;
use App\Models\Link;
use App\Models\Tag;
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
     * タグとのリレーション
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
