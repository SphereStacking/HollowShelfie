<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use Carbon\Carbon;
use App\Enums\EventStatus;
use Illuminate\Support\Facades\Log;
use App\Services\DynamicSearch\Meilisearch\MeilisearchFilter;

/**
 * ステータスクエリパラメータクラス
 */
class EventFilterStatus extends MeilisearchFilter
{
    public function formatValue()
    {
        $scope = match ($this->value) {
            EventStatus::UPCOMING->value => $this->scopeUpcomingPublished(),
            EventStatus::ONGOING->value => $this->scopeOngoingPublished(),
            EventStatus::CLOSED->value => $this->scopeClosedPublished(),
            default => $this->scopeGeneralPublished(),
        };
        return $scope;
    }

    protected function where($value): string
    {
        return " AND ({$value})";
    }

    protected function whereOr($value): string
    {
        return " OR ({$value})";
    }

    protected function whereNot($value): string
    {
        return " AND NOT ({$value})";
    }



    /**
     * 一般公開しているイベントのスコープ。
     * - EventStatus::UPCOMING
     * - EventStatus::ONGOING
     * - EventStatus::CLOSED
     */
    public function scopeGeneralPublished(): string
    {
        $now = Carbon::now()->getTimestamp();
        return 'is_forced_hidden = false AND published_at < ' . $now;
    }

    /**
     * 一般公開しているClosedイベントのスコープ。
     */
    public function scopeClosedPublished(): string
    {
        $now = Carbon::now()->getTimestamp();
        return 'is_forced_hidden = false AND published_at < ' . $now . ' AND end_date < ' . $now;
    }

    /**
     * 一般公開しているOngoingイベントのスコープ。
     */
    public function scopeOngoingPublished(): string
    {
        $now = Carbon::now()->getTimestamp();
        return 'is_forced_hidden = false AND published_at < ' . $now . ' AND ( start_date < ' . $now . ' AND end_date > ' . $now . ')';
    }

    /**
     * 一般公開しているUpcomingイベントのスコープ。
     */
    public function scopeUpcomingPublished(): string
    {
        $now = Carbon::now()->getTimestamp();
        return 'is_forced_hidden = false AND published_at < ' . $now . ' AND start_date > ' . $now;
    }



}
