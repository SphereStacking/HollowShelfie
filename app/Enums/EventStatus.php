<?php

namespace App\Enums;

/**
 * イベントのステータスを表す列挙型
 */
enum EventStatus: string
{
    /** イベントが強制的に非公開にされている場合 */
    case FORCED_HIDDEN = 'forced_hidden';
    /** イベントが公開準備中（ドラフト） */
    case DRAFT = 'draft';
    /** ベントがまだ公開されていない場合 */
    case UNPUBLISHED = 'unpublished';
    /** イベントの開始前 */
    case UPCOMING = 'upcoming';
    /** イベントが進行中 */
    case ONGOING = 'ongoing';
    /** イベントが終了 */
    case CLOSED = 'closed';

    /** 公開検索用のステータス */
    public const PUBLIC_SEARCH_STATUSES = [
        self::ONGOING,
        self::CLOSED,
        self::UPCOMING,
    ];
}
