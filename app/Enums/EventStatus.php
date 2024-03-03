<?php

namespace App\Enums;

/**
 * イベントのステータスを表す列挙型
 */
enum EventStatus: string
{
    case DRAFT = 'draft';
    case CLOSED = 'closed';
    case UPCOMING = 'upcoming';
    case CANCELED = 'canceled';
    case DELETED = 'deleted';
    case ONGOING = 'ongoing';

    private const STATUS_MAP = [
        'ongoing' => '開催中',
        'upcoming' => '予定',
        'closed' => '終了',
        'canceled' => 'キャンセル',
        'scheduled' => '公開予約中',
        'draft' => '下書き',
        'deleted' => '削除',
    ];

    /**
     * ステータス文字列をEventStatus列挙型に変換します。
     *
     * @param string $status ステータス文字列
     * @return EventStatus|null ステータス文字列に対応するEventStatus列挙型
     */
    public static function getStatus(string $status): ?EventStatus
    {
        return match ($status) {
            'draft' => self::DRAFT,
            'closed' => self::CLOSED,
            'upcoming' => self::UPCOMING,
            'canceled' => self::CANCELED,
            'deleted' => self::DELETED,
            'ongoing' => self::ONGOING,
            default => null,
        };
    }

    /**
     * ラベルを元にステータス文字列を取得します。
     *
     * @param string $label ラベル
     * @return string|null ラベルに対応するステータス文字列
     */
    public static function getRawStatus(string $label): ?string
    {
        return array_search($label, self::STATUS_MAP) ?: null;
    }

    /**
     * ステータス文字列を元にラベルを取得します。
     *
     * @param string $status ステータス文字列
     * @return string|null ステータス文字列に対応するラベル
     */
    public static function getStatusLabel(string $status): ?string
    {
        return self::STATUS_MAP[$status] ?? null;
    }

    /**
     * 全てのステータス文字列を取得します。
     *
     * @return array ステータス文字列の配列
     */
    public static function getAllStatuses(): array
    {
        return array_keys(self::STATUS_MAP);
    }

    /**
     * 全てのステータスマップを取得します。
     *
     * @return array ステータスマップの配列
     */
    public static function getAllStatusMap(): array
    {
        return self::STATUS_MAP;
    }

    /**
     * リスト検索で許可されているステータスを取得します。
     *
     * @return array 許可されているステータスの配列
     */
    public static function getPermittedStatusesForListSearch(): array
    {
        $selectedStatuses = ['ongoing', 'closed', 'upcoming', 'canceled', 'ongoing'];
        return array_intersect_key(self::STATUS_MAP, array_flip($selectedStatuses));
    }

    /**
     * 管理検索で許可されているステータスを取得します。
     *
     * @return array 許可されているステータスの配列
     */
    public static function getPermittedStatusesForAdminSearch(): array
    {
        $selectedStatuses = ['ongoing', 'closed', 'upcoming', 'canceled', 'ongoing','draft'];
        return array_intersect_key(self::STATUS_MAP, array_flip($selectedStatuses));
    }
}
