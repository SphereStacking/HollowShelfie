<?php

namespace App\Models\Traits;

use App\Enums\EventStatus;
use Carbon\Carbon;
use DateTimeImmutable;
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
    public function getCategoryNameAttribute(): ?string
    {
        return $this->categories->first() ? $this->categories->first()->name : null;
    }

    /**
     * 関連付けられているカテゴリの名前を返す
     */
    public function getCategoryNamesAttribute(): array
    {
        return $this->categories->pluck('name')->toArray();
    }

    /**
     * 関連付けられているカテゴリの名前を返す
     */
    public function getTagNamesAttribute(): array
    {
        return $this->tags->pluck('name')->toArray();
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
            'weekday' => mb_strtolower($startDate->format('D')),
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
            'weekday' => mb_strtolower($endDate->format('D')),
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
        return $this->good_users->count();
    }

    /**
     * good数の短い表記
     */
    public function getShortGoodCountAttribute(): string
    {
        $count = $this->good_users->count();
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



    public function getStatusAttribute()
    {
        $now = now();

        // イベントが強制的に非公開にされている場合
        if ($this->is_forced_hidden) {
            return 'UNPUBLISHED';
        }

        // イベントが公開準備中（ドラフト）
        if (is_null($this->publish_at)) {
            return 'DRAFT';
        }

        // イベントがまだ公開されていない場合
        if ($this->publish_at > $now) {
            return 'UNPUBLISHED';
        }

        // イベントの開始前
        if ($this->start_date > $now) {
            return 'UPCOMING';
        }

        // イベントが進行中
        if ($this->start_date <= $now && $this->end_date >= $now) {
            return 'ONGOING';
        }

        // イベントが終了した
        if ($this->end_date < $now) {
            return 'CLOSED';
        }
    }
}
