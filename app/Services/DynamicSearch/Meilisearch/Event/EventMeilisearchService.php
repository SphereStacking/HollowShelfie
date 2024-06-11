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
        $queryfilterString = $this->createMakeFilter($params->queryParams);

        $filterString = "(".$optionsFilter.") " . ($queryfilterString ? "AND (".$queryfilterString.")" : "");

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

    // クエリパラメータを作成し、フィルタ文字列を生成する
    private function createMakeFilter(array $queryParams): string {
        $filterString = '';
        foreach ($queryParams as $index => $item) {
            $type = $item['type'];
            if (isset($this->queryParamClasses[$type])) {
                $class = $this->queryParamClasses[$type];
                // 各タイプに応じたフィルタクラスをインスタンス化し、フィルタ文字列を生成
                $filterInstance = new $class($item['include'], $type, $item['value'], $index === 0);
                $filterString .= $filterInstance->makeQuery();
            }
        }
        return $filterString;
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
            case 'old':
                return $query->orderBy('published_at', 'asc');
            default:
                return $query->orderBy('published_at', 'desc');
        }
    }
}







