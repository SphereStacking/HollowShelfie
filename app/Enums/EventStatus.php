<?php

namespace App\Enums;

/**
 * イベントのステータスを表す列挙型
 */
enum EventStatus: string
{
    /** 開催中 */
    case ONGOING = 'ongoing';
    /** 予定 */
    case UPCOMING = 'upcoming';
    /** 終了 */
    case CLOSED = 'closed';
    /** キャンセル */
    case CANCELED = 'canceled';
    /** 公開予約中 */
    case SCHEDULED = 'scheduled';
    /** 下書き */
    case DRAFT = 'draft';
    /** 削除 */
    case DELETED = 'deleted';

    public function label(): string
    {
        return match($this) {
            self::ONGOING => '開催中',
            self::UPCOMING => '予定',
            self::CLOSED => '終了',
            self::CANCELED => 'キャンセル',
            self::SCHEDULED => '公開予約中',
            self::DRAFT => '下書き',
            self::DELETED => '削除',
        };
    }

    /** 公開済みのステータス */
    public const PUBLISHED_STATUSES = [
        self::ONGOING,
        self::CLOSED,
        self::CANCELED,
        self::UPCOMING,
        self::SCHEDULED,
    ];

    /** 管理者検索用のステータス */
    public const ADMIN_SEARCH_STATUSES = [
        self::ONGOING,
        self::CLOSED,
        self::UPCOMING,
        self::CANCELED,
        self::DRAFT,
    ];

    /** 公開検索用のステータス */
    public const PUBLIC_SEARCH_STATUSES = [
        self::ONGOING,
        self::CLOSED,
        self::UPCOMING,
        self::CANCELED,
    ];

    /**
     * ラベルを元にステータス文字列を取得します。
     *
     * @param string $label ラベル
     * @return string|null ラベルに対応するステータス文字列
     */
    public static function getRawStatus(string $label): ?string
    {
        foreach (self::cases() as $case) {
            if ($case->label() === $label) {
                return $case->value;
            }
        }
        return null;
    }

    /**
     * ステータス文字列を元にラベルを取得します。
     *
     * @param string $status ステータス文字列
     * @return string|null ステータス文字列に対応するラベル
     */
    public static function getStatusLabel(string $status): ?string
    {
        return self::tryFrom($status)?->label();
    }

}
