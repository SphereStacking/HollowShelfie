<?php

namespace App\Models\Traits;

use DateTime;
use Carbon\Carbon;
use App\Enums\EventStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

trait EventGetters
{
    /**
     * イベントのオーガナイザー名を取得
     */
    public function getCreatedUserAttribute(): string
    {
        return $this->event_create_user->name;
    }

    /**
     * イベントのタグ名を取得
     */
    public function getTagsAttribute(): array
    {
        // タグのnameプロパティだけを配列にして返す
        return $this->tags()->pluck('name')->toArray();
    }

    /**
     * ユーザーがイベントを"bookmark"しているか確認
     */
    public function getIsBookmarkAttribute(): bool
    {
        $user = Auth::user();
        return $user ? $user->bookmark_events->contains($this->id) : false;

    }

    /**
     * ユーザーがイベントを"good"しているか確認
     */
    public function getIsGoodAttribute(): bool
    {
        $user = Auth::user();
        return $user ? $user->good_events->contains($this->id) : false;
    }

    /**
     * 関連付けられているカテゴリの中から最初の名前を返す
     */
    public function getCategoryNameAttribute(): string|null
    {
        return $this->categories->first() ? $this->categories->first()->name : null;
    }

    /**
     * 関連付けられているカテゴリの名前を返す
     *
     */
    public function getCategoryNamesAttribute(): array
    {
        return $this->categories->pluck('name')->toArray();
    }

    /**
     * 関連付けられているインスタンス
     */
    public function getInstancesAttribute(): Collection
    {
        return $this->instances()->get();
    }

    /**
     * 現在からイベント開始までの時間（時間単位）を取得
     */
    public function getEventTimelineStatusAttribute(): string
    {
        $now = new DateTime();
        $startDate = new DateTime($this->start_date);
        $endDate = new DateTime($this->end_date);

        // イベントが開催中かどうかを確認
        if ($now >= $startDate && $now <= $endDate) {
            return '開催中';
        }

        // イベントが終了しているかどうかを確認
        if ($now > $endDate) {
            return '終了';
        }

        $interval = $now->diff($startDate);

        // 時間単位で返す（小数点2以下は切り捨て）
        $hoursUntilStart = floor(($interval->h + ($interval->i / 60)) * 10) / 10;

        // 1日以上ある場合は指定した形式で表示、1時間以上1日未満は時間で表示、1時間未満は分で表示
        if ($interval->d >= 1) {
            return $startDate->format('Y/m/d H:i');
        } elseif ($hoursUntilStart >= 1) {
            return $hoursUntilStart.'時間後';
        } else {
            return $interval->i.'分後';
        }
    }

    /**
     * 開始日をフォーマット
     */
    public function getFormattedStartDateAttribute(): array
    {
        $startDate = new Carbon($this->start_date);
        $startDate->setLocale('ja');

        return [
            'year' => $startDate->format('Y'),
            'month' => $startDate->format('m'),
            'day' => $startDate->format('d'),
            'weekday' => strtolower($startDate->format('D')),
            'time' => $startDate->format('H:i'),
        ];
    }

    /**
     * 終了日をフォーマット
     */
    public function getFormattedEndDateAttribute(): array
    {
        $endDate = new Carbon($this->end_date);
        $endDate->setLocale('ja');

        return [
            'year' => $endDate->format('Y'),
            'month' => $endDate->format('m'),
            'day' => $endDate->format('d'),
            'weekday' => strtolower($endDate->format('D')),
            'time' => $endDate->format('H:i'),
        ];
    }

    /**
     * Event開催期間
     */
    public function getPeriodAttribute(): string
    {
        $startDate = new Carbon($this->start_date);
        $endDate = new Carbon($this->end_date);

        // 日付が同じ場合は、開始時間と終了時間のみ表示
        if ($startDate->format('Y/m/d') === $endDate->format('Y/m/d')) {
            return $startDate->format('Y/m/d H:i').' ~ '.$endDate->format('H:i');
        } else {
            return $startDate->format('Y/m/d H:i').' ~ '.$endDate->format('Y/m/d H:i');
        }
    }

    /**
     * good数 省略無し
     */
    public function getGoodCountAttribute(): int
    {
        return $this->good_users()->count();
    }

    /**
     * good数の短い表記
     */
    public function getShortGoodCountAttribute(): string
    {
        $count = $this->good_users()->count();
        $suffix = '';

        if ($count >= 1000 && $count < 1000000) {
            $count /= 1000;
            $suffix = 'K';
        } elseif ($count >= 1000000) {
            $count /= 1000000;
            $suffix = 'M';
        }

        return round($count, 1).$suffix;
    }

    /**
     * statusのlabel
     */
    public function getStatusLabelAttribute(): string
    {
        return EventStatus::getStatusLabel($this->status);
    }
}
