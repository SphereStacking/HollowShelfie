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

    private $with = [
        'organizers.event_organizeble',
        'event_time_tables.performers.performable',
        'files',
        'instances',
        'tags.taggables.tag',
        'categories',
        'good_users',
        'event_create_user',
    ];

    private $withCount = [
        'good_users',
    ];

    /**
     * クエリパラメータクラス
     *
     * @var array<string, class-string>
     */
    private $queryParamClasses = [
        'date' => EventFilterDate::class,
        'status' => EventFilterStatus::class,
        'tag' => EventFilterTag::class,
        'category' => EventFilterCategory::class,
        'organizer' => EventFilterOrganizer::class,
        'performer' => EventFilterPerformer::class,
        'instance' => EventFilterInstance::class,
    ];

    /** 公開されたイベントを検索する */
    public function searchPublishedEvents(SearchParams $params): LengthAwarePaginator
    {
        $publishedFilter = new EventSystemFilterPublished();
        return $this->searchEvents($publishedFilter->makeQuery(), $params);
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
        $queryParams = $this->createQueryParams($params->queryParams);
        $queryfilterString = $this->makeFilter($queryParams);

        $filterString = $optionsFilter . $queryfilterString;
        Log::info($filterString);
        return Event::search(
            query: $params->text,
            callback: function (Indexes $meilisearch, $query, array $options) use ($filterString) {
                $options['filter'] = $filterString;
                return $meilisearch->rawSearch($query, $options);
            })
            // order
            ->query(function ($query) use ($params) {
                return $this->orderScopes($query, $params->order);
            })
            //Eager Loading
            ->query(function ($query) {
                return $query->with($this->with)->withCount($this->withCount);
            })
            // ---
            ->paginate($params->paginate)
            ->appends(request()->query());
    }

    // 検索パラメータを作成する
    private function createQueryParams(array $queryParams): array {
        $result = [];
        foreach ($queryParams as $item) {
            $type = $item['type'];
            if (isset($this->queryParamClasses[$type])) {
                $class = $this->queryParamClasses[$type];
                // 各タイプに応じたフィルタクラスをインスタンス化
                $result[] = new $class($item['include'], $type, $item['value']);
            }
        }
        return $result;
    }
    // クエリパラメータに基づいてフィルタ文字列を作成する
    private function makeFilter(array $queryParams): string {
        return array_reduce($queryParams, function ($carry, $item) {
            return $carry . $item->makeQuery();
        }, '');
    }

    /**
     * オーダースコープを取得する
     *
     * @return Builder
     */
    private function orderScopes(Builder $query, string $order): Builder
    {
        switch ($order) {
            case 'good':
                return $query->orderBy('good_count', 'desc');
            case 'new':
                return $query->orderBy('published_at', 'desc');
            default:
                return $query->orderBy('published_at', 'desc');
        }
    }
}







