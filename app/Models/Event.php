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

    protected $fillable = ['title', 'description'];
    protected $appends = [
        'organizer', 'organizer_id', 'formatted_date_time', 'status_labl', 'tags',
        'is_like', 'is_good'

    ];
    public function getOrganizerIdAttribute()
    {
        return $this->user->id;
    }
    public function getOrganizerAttribute()
    {
        // TODO: 作成したユーザーがオーガナイザーとは限らない。
        // return $this->organizer->name;
        return $this->user->name;
    }

    public function getTagsAttribute()
    {
        // タグのnameプロパティだけを配列にして返す
        return $this->tags()->pluck('name')->toArray();
    }

    public function getIsLikeAttribute()
    {
        return Auth::user()->like_events->contains($this->id);
    }

    public function getIsGoodAttribute()
    {
        return Auth::user()->good_events->contains($this->id);
    }


    public function getFormattedDateTimeAttribute()
    {
        // 日付と時刻のデータを取得
        $startDate = $this->start_date;
        $endDate = $this->end_date;

        // Y年m月d日 H:i~H:i 形式に変換
        $formattedDate = date('Y年m月d日', strtotime($startDate));
        $formattedStartTime = date('H:i', strtotime($startDate));
        $formattedEndTime = date('H:i', strtotime($endDate));

        // フォーマットした日付と時刻を結合して返す
        return $formattedDate . ' ' . $formattedStartTime . '~' . $formattedEndTime;
    }

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

    //
    public function scopeSection($query, $section)
    {
        if ($section == 'new') {
            return $query->orderBy('created_at', 'asc');
        }
        if ($section == 'new') {
            return $query->orderBy('created_at', 'asc');
        }
        if ($section == 'new') {
            return $query->orderBy('created_at', 'asc');
        }
    }

    //イベントを作成したユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //イベントを作成したユーザー
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
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

    //
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    //紐づくファイル。
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function schedules()
    {
        return $this->hasMany(EventSchedule::class);
    }

    public function performers()
    {
        return $this->hasMany(Performer::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function userEvents()
    {
        return $this->hasMany(UserEvent::class);
    }
}
