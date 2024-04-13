<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Event;
use App\Params\EventSearchParams;
use App\Models\Traits\EventScopes;
use Meilisearch\Endpoints\Indexes;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * イベント検索サービス
 */
class EventMeilisearchService
{
    use EventScopes;

    /**
     * クエリパラメータクラス
     *
     * @var array
     */
    private $queryParamClasses = [
        'date' => DateScoutQueryParam::class,
        'status' => StatusScoutQueryParam::class,
        'tag' => TagScoutQueryParam::class,
        'category' => CategoryScoutQueryParam::class,
    ];

    /**
     * オーダースコープ
     *
     * @var array
     */
    private $orderScopes = [
        'good' => 'scopeOrderByGoodUserCountForScout',
        'new' => 'scopeOrderByNewest',
        'view' => 'scopeOrderByViews',   // TODO:いつかやろうね
        'trend' => 'scopeOrderByTrendiness', // TODO:いつかやろうね
    ];

    /**
     * 公開イベント検索を取得
     */
    public function getPublishedEventSearch(EventSearchParams $params):LengthAwarePaginator
    {
        $queryParams = [];
        foreach ($params->queryParams as $item) {
            $type = $item['type'];
            if (array_key_exists($type, $this->queryParamClasses)) {
                $class = $this->queryParamClasses[$type];
                $queryParams[] = new $class($item['include'], $type, $item['value']);
            }
        }
        $filterString = $this->makeFilter($queryParams);
        $events = Event::search(
            query: $params->text,
            callback: function (Indexes $meilisearch, $query, array $options) use ($filterString) {
                $options['filter'] =
                    'published_at < '.Carbon::now()->getTimestamp().$filterString;
                return $meilisearch->rawSearch(
                    $query,
                    $options,
                );
            },
        );

        if (array_key_exists($params->order, $this->orderScopes)) {
            $scopeMethod = $this->orderScopes[$params->order];
            $events = $this->$scopeMethod($events);
        }

        $events = $this->scopeWithStatusPublishedForScout($events);

        return $events
            ->paginate($params->paginate)
            ->appends(request()->query());
    }

    /**
     * 検索クエリを処理
     *
     * @param $query
     * @param $item
     */
    private function makeFilter(array $queryParams)
    {
        $filterString = '';
        foreach ($queryParams as $item) {
            $filterString .= $item->makeQuery();
        }

        return $filterString;
    }
}

/**
 * クエリパラメータインターフェース
 */
interface IScoutQueryParam
{
    public function __construct($include, $type, $value);

    public function makeQuery();

    public function formatValue();
}

/**
 * クエリパラメータ抽象クラス
 */
abstract class ScoutQueryParam
{
    protected $column;

    public $include;

    public $type;

    public $value;

    /**
     * 条件マップ
     *
     * @var array
     */
    public $conditionMaps = [
        'and' => 'where',
        'or' => 'WhereOr',
        'not' => 'whereNot',
    ];

    public function __construct($include, $type, $value)
    {
        $this->include = $include;
        $this->type = $type;
        $this->value = $value;
    }

    public function makeQuery()
    {
        $method = $this->conditionMaps[$this->include];

        return $this->$method($this->column, $this->formatValue());
    }

    private function buildQuery($operator, $column, $value)
    {
        if (is_array($value)) {
            return " {$operator} ({$column} > {$value[0]} AND {$column} < {$value[1]})";
        } else {
            $value = is_numeric($value) ? $value : "\"{$value}\"";

            return " {$operator} {$column} = {$value}";
        }
    }

    private function where($column, $value)
    {
        return $this->buildQuery('AND', $column, $value);
    }

    private function whereOr($column, $value)
    {
        return $this->buildQuery('OR', $column, $value);
    }

    private function whereNot($column, $value)
    {
        $value = is_numeric($value) ? $value : "\"{$value}\"";

        return " AND NOT {$column} = {$value}";
    }

    /**
     * 値をフォーマットする
     */
    abstract public function formatValue();
}

/**
 * 日付クエリパラメータクラス
 */
class DateScoutQueryParam extends ScoutQueryParam implements IScoutQueryParam
{
    protected $column = 'start_date';

    public function formatValue()
    {
        if (is_string($this->value) && strpos($this->value, '~') !== false) {
            [$start, $end] = explode('~', $this->value);

            return [Carbon::parse($start)->getTimestamp(), Carbon::parse($end)->getTimestamp()];
        }

        return $this->value;
    }
}

/**
 * ステータスクエリパラメータクラス
 */
class StatusScoutQueryParam extends ScoutQueryParam implements IScoutQueryParam
{
    protected $column = 'status_label';

    public function formatValue()
    {
        return $this->value;
    }
}

/**
 * タグクエリパラメータクラス
 */
class TagScoutQueryParam extends ScoutQueryParam implements IScoutQueryParam
{
    protected $column = 'tags';

    public function formatValue()
    {
        return $this->value;
    }
}

/**
 * カテゴリクエリパラメータクラス
 */
class CategoryScoutQueryParam extends ScoutQueryParam implements IScoutQueryParam
{
    protected $column = 'categories';

    public function formatValue()
    {
        return $this->value;
    }
}
