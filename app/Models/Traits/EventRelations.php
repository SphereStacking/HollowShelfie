<?php

namespace App\Models\Traits;

use App\Models\Tag;
use App\Models\File;
use App\Models\User;
use App\Models\View;
use App\Models\Category;
use App\Models\Instance;
use App\Models\EventOrganizer;
use App\Models\EventTimeTable;

/**
 * イベント関連のトレイト
 */
trait EventRelations
{
    /**
     * イベント作成ユーザーとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event_create_user()
    {
        return $this->belongsTo(User::class, 'event_create_user_id');
    }

    /**
     * インスタンスとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function instances()
    {
        return $this->hasMany(Instance::class);
    }

    /**
     * ブックマークユーザーとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bookmark_users()
    {
        return $this->belongsToMany(User::class, 'event_user_bookmark');
    }

    /**
     * 良いユーザーとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function good_users()
    {
        return $this->belongsToMany(User::class, 'event_user_good');
    }

    /**
     * カテゴリとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * ファイルとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }



    /**
     * タグとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * イベントタイムテーブルとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function event_time_tables()
    {
        return $this->hasMany(EventTimeTable::class);
    }

    /**
     * オーガナイザーとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organizers()
    {
        return $this->hasMany(EventOrganizer::class);
    }

    /**
     * スケジュールとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules()
    {
        return $this->hasMany(EventSchedule::class);
    }

    /**
     * ビューとのリレーション
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphManｊy
     */
    public function view()
    {
        return $this->morphOne(View::class, 'viewable');
    }
}
