<?php

namespace App\Models\Traits;

use App\Models\Badge;
use App\Models\EventOrganizer;
use App\Models\Link;
use App\Models\Tag;

/**
 * ユーザー関連のトレイト
 */
trait TeamRelations
{
    /**
     * このTeamのイベントオーガナイザー取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function event_organizers()
    {
        return $this->morphMany(EventOrganizer::class, 'event_organizeble');
    }

    /**
     * リンク取得
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
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
