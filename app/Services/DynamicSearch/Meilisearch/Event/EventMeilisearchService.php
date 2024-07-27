<?php

namespace App\Services\DynamicSearch\Meilisearch\Event;

use App\Models\Event;
use Laravel\Scout\Builder;
use App\Models\Traits\EventScopes;
use Meilisearch\Endpoints\Indexes;
use Illuminate\Support\Facades\Log;
use App\Services\DynamicSearch\Meilisearch\SearchParams;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * イベント検索サービス
 */
class EventMeilisearchService
{
    use EventScopes;

    /** Eager Loading するリレーション */
    private const WITH = [
        'organizers.event_organizeble',
        'event_time_tables.performers.performable',
        'files',
        'instances.instance_type',
        'tags.taggables.tag',
        'categories',
        'good_users',
        'event_create_user',
    ];

    /** Eager Loading するリレーションのカウント */
    private const WITH_COUNT = [
        'good_users',
    ];

    /**
     * クエリパラメータクラス
     *
     * @var array<string, class-string>
     */
    private const QUERY_PARAM_CLASSES = [
        'date' => EventFilterDate::class,
        'status' => EventFilterStatus::class,
        'tag' => EventFilterTag::class,
        'category' => EventFilterCategory::class,
        'organizer' => EventFilterOrganizer::class,
        'performer' => EventFilterPerformer::class,
        'instance' => EventFilterInstance::class,
    ];

    /** 並び順のカラムオプション */
    private const ORDER_BY_COLUMNS = [
        'good' => 'good_count',
        'new' => 'published_at',
        'old' => 'published_at',
        'start_date' => 'start_date',
        'created_at' => 'created_at',
        'default' => 'published_at',
    ];

    /** 並び順の方向オプション */
    private const ORDER_DIRECTIONS = [
        'asc' => 'ASC',
        'desc' => 'DESC',
        'default' => 'DESC',
    ];

    /** デフォルトの並び順設定 */
    private const DEFAULT_ORDER_SETTINGS = [
        'good' => ['column' => 'good_count', 'direction' => 'DESC'],
        'new' => ['column' => 'published_at', 'direction' => 'DESC'],
        'old' => ['column' => 'published_at', 'direction' => 'ASC'],
        'start_date' => ['column' => 'start_date', 'direction' => 'ASC'],
        'created_at' => ['column' => 'created_at', 'direction' => 'DESC'],
        'default' => ['column' => 'published_at', 'direction' => 'DESC'],
    ];


    /** 公開されたイベントを検索する */
    public function searchPublishedEvents(SearchParams $params): LengthAwarePaginator
    {
        $publishedFilter = new EventSystemFilterPublished();
        $result = $this->searchEvents($publishedFilter->makeQuery(), $params);
        return $result;
    }

    /** 特定のユーザーが作成したイベントを検索する */
    public function searchManageableEvents(SearchParams $params): LengthAwarePaginator
    {
        $userFilter = new EventSystemFilterCreaterById();
        return $this->searchEvents($userFilter->makeQuery(), $params);
    }

    /** イベントを検索する共通メソッド */
    private function searchEvents(string $optionsFilter,SearchParams $params): LengthAwarePaginator
    {
        $orderBy = $this->getOrderSettings($params->order, $params->direction);
        $queryfilterString = $this->createMakeFilter($params->queryParams);
        $filterString = "(".$optionsFilter.") " . ($queryfilterString ? "AND (".$queryfilterString.")" : "");

        return Event::search(
                query: $params->text,
                callback: function (Indexes $meilisearch, $query, array $options) use ($filterString) {
                    $options['filter'] = $filterString;
                    return $meilisearch->rawSearch($query, $options);
                }
            )
            ->orderBy($orderBy['column'], $orderBy['direction'])
            ->query(function ($query) {
                // Eager Loading
                return $query->with(self::WITH)->withCount(self::WITH_COUNT);
            })
            ->paginate($params->paginate)
            ->appends(request()->query());
    }

    // クエリパラメータを作成し、フィルタ文字列を生成する
    private function createMakeFilter(array $queryParams): string {
        $filterString = '';
        foreach ($queryParams as $index => $item) {
            $type = $item['type'];
            $class = $this->parseQueryParamClass($type);
            if ($class) {
                // 各タイプに応じたフィルタクラスをインスタンス化し、フィルタ文字列を生成
                $filterInstance = new $class($item['include'], $type, $item['value'], $index === 0);
                $filterString .= $filterInstance->makeQuery();
            }
        }
        return $filterString;
    }

    /**
     * 並び順の設定を取得する
     * フロントから悪意あるクエリパラメータが来てもエラーが出ないようにするためのparse処理
     *
     * @param string $order 並び順
     * @param string $direction 並び順の方向
     * @return array<string, string> カラム名と方向を含む連想配列を返す
     */
    private function getOrderSettings(string $order = 'default', string $direction = 'default'): array
    {
        // 指定された order に対応するカラム名を取得
        $orderByColumn = self::ORDER_BY_COLUMNS[$order] ?? self::DEFAULT_ORDER_SETTINGS['default']['column'];
        // 指定された direction に対応する方向を取得
        $orderDirection = self::ORDER_DIRECTIONS[$direction] ?? self::DEFAULT_ORDER_SETTINGS['default']['direction'];
        return ['column' => $orderByColumn, 'direction' => $orderDirection];
    }

    /**
     * クエリパラメータクラスを取得する
     * フロントから悪意あるクエリパラメータが来てもエラーが出ないようにするためのparse処理
     *
     * @param string $type クエリパラメータのタイプ
     * @return class-string|null クエリパラメータクラス
     */
    private function parseQueryParamClass(string $type)
    {
        return self::QUERY_PARAM_CLASSES[$type] ?? null;
    }
}
