<?php

namespace App\Models;

use DateTime;
use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    use HasFactory;

    /**
     * @var array 可変の属性
     */
    protected $fillable = ['title', 'description'];

    /**
     * @var array 可変の属性
     */
    protected $appends = [
        'created_user', 'formatted_date_time', 'status_labl', 'tags',
        'is_like', 'is_good', 'category_name', 'instances',
    ];

    /**
     * イベントのオーガナイザーIDを取得
     *
     * @return int
     */
    public function getOrganizerIdAttribute()
    {
        return $this->user->id;
    }

    /**
     * イベントのオーガナイザー名を取得
     *
     * @return string
     */
    public function getCreatedUserAttribute()
    {
        return $this->user->name;
    }

    /**
     * イベントのタグ名を取得
     *
     * @return array
     */
    public function getTagsAttribute()
    {
        // タグのnameプロパティだけを配列にして返す
        return $this->tags()->pluck('name')->toArray();
    }

    /**
     * ユーザーがイベントを"like"しているか確認
     *
     * @return bool
     */
    public function getIsLikeAttribute()
    {
        return Auth::user()->like_events->contains($this->id);
    }

    /**
     * ユーザーがイベントを"good"しているか確認
     *
     * @return bool
     */
    public function getIsGoodAttribute()
    {
        return Auth::user()->good_events->contains($this->id);
    }

    /**
     * 関連付けられているカテゴリの中から最初の名前を返す
     *
     * @return string|null
     */
    public function getCategoryNameAttribute()
    {
        return $this->categories->first() ? $this->categories->first()->name : null;
    }

    /**
     * 関連付けられているインスタンスの中から最初の名前を返す
     *
     * @return string|null
     */
    public function getInstancesAttribute()
    {
        return $this->instances()->get();
    }

    //表示用に時刻のデータをformatして返す
    public function getFormattedDateTimeAttribute()
    {
        // 日付と時刻のデータを取得
        $startDate = $this->start_date;
        $endDate = $this->end_date;

        // Y年m月d日 H:i~H:i 形式に変換
        $formattedDate = date('Y年m月d日', strtotime($startDate));
        $formattedStartTime = date('H:i', strtotime($startDate));
        $formattedEndTime = date('H:i', strtotime($endDate));

        // フォーマットしでた日付と時刻を結合して返す
        return $formattedDate . ' ' . $formattedStartTime . '~' . $formattedEndTime;
    }

    // ステータスのlabelを返す
    public function getStatusLablAttribute()
    {
        return EventStatus::getStatusLabel($this->status);
    }


    // タグに基づいてフィルタするクエリスコープ
    public function scopeFilterByTags($query, $tags)
    {
        if ($tags) {
            // タグの名前で絞り込む
            $query->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('name', $tags);
            });
        }
        return $query;
    }

    //イベントを作成したユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //イベントに紐づくinstance
    public function instances()
    {
        return $this->hasMany(Instance::class);
    }

    //♡をしたusers
    public function like_users()
    {
        return $this->belongsToMany(User::class, 'event_user_like');
    }

    //👍をしたusers
    public function good_users()
    {
        return $this->belongsToMany(User::class, 'event_user_good');
    }

    //紐づくcategoryを返す。
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    //紐づくファイル。
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    //Eventに紐づくタグ
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    //Eventに紐づくUser(Performer)
    public function performers()
    {
        // Pivotでstart_timeとend_timeを取得
        return $this->belongsToMany(User::class, 'event_user_performer')
            ->using(EventUserPerformer::class)
            ->withPivot('start_time', 'end_time');
    }

    public function organizers()
    {
        return $this->hasMany(EventOrganizer::class);
    }


    public function schedules()
    {
        return $this->hasMany(EventSchedule::class);
    }
}
