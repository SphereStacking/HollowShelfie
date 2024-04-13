<?php

namespace App\Models\Traits;

use App\Models\Category;
use App\Models\EventOrganizer;
use App\Models\EventTimeTable;
use App\Models\Instance;
use App\Models\Tag;
use App\Models\User;
use App\Models\View;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * イベント関連のトレイト
 */
trait EventRelations
{
    /**
     * イベント作成ユーザーとのリレーション
     */
    public function event_create_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'event_create_user_id');
    }

    /**
     * インスタンスとのリレーション
     */
    public function instances(): HasMany
    {
        return $this->hasMany(Instance::class);
    }

    /**
     * ブックマークユーザーとのリレーション
     */
    public function bookmark_users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user_bookmark');
    }

    /**
     * 良いユーザーとのリレーション
     */
    public function good_users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user_good');
    }

    /**
     * カテゴリとのリレーション
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * タグとのリレーション
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * イベントタイムテーブルとのリレーション
     */
    public function event_time_tables(): HasMany
    {
        return $this->hasMany(EventTimeTable::class);
    }

    /**
     * オーガナイザーとのリレーション
     */
    public function organizers(): HasMany
    {
        return $this->hasMany(EventOrganizer::class);
    }

    /**
     * ビューとのリレーション
     */
    public function view(): MorphOne
    {
        return $this->morphOne(View::class, 'viewable');
    }
}
