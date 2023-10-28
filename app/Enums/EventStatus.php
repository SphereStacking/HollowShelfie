<?php

namespace App\Enums;

enum EventStatus: string
{
    case DRAFT = 'draft';
    case CLOSED = 'closed';
    case UPCOMING = 'upcoming';
    case CANCELED = 'canceled';
    case DELETED = 'deleted';
    case ONGOING = 'ongoing';

    private const STATUS_MAP = [
        'draft' => '下書き',
        'upcoming' => '予定',
        'closed' => '終了',
        'canceled' => 'キャンセル',
        'deleted' => '削除',
        'ongoing' => '開催中',
    ];

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

    public static function getStatusLabel(string $status): ?string
    {
        return self::STATUS_MAP[$status] ?? null;
    }
    public static function getAllStatuses(): array
    {
        return array_keys(self::STATUS_MAP);
    }
}
