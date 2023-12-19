<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Event;
use App\Enums\EventStatus;
use App\Params\EventSearchParams;
use App\Models\Traits\EventScopes;
use Illuminate\Support\Facades\Log;


/**
 * イベント検索サービス
 */
class EventMeilisearchService_query
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
        'user' => UsrerScoutQueryParam::class,
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
     *
     * @param EventSearchParams $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPublishedEventSearch(EventSearchParams $params)
    {
        $events = Event::search($params->text);
        $queryParams = [];

        foreach ($params->queryParams as $item) {
            $type = $item['type'];
            if (array_key_exists($type, $this->queryParamClasses)) {
                $class = $this->queryParamClasses[$type];
                $queryParams[] = new $class($item['include'], $type, $item['value']);
            }
        }

        foreach ($queryParams as $item) {
            $this->handleSearchQuery($events, $item);
        }

        if (array_key_exists($params->order, $this->orderScopes)) {
            $scopeMethod = $this->orderScopes[$params->order];
            $events = $this->$scopeMethod($events);
        }

        $events = $this->scopeWithStatusPublishedForScout($events);
        return $events
            ->paginate($params->paginate)
            ->withQueryString();
    }

    /**
     * 検索クエリを処理
     *
     * @param $query
     * @param $item
     */
    private function handleSearchQuery($query, IScoutQueryParam $queryParam)
    {
        $value = $queryParam->formatValue($queryParam->value);
        $queryParam->makeQuery($query, $value);
    }
}


/**
 * クエリパラメータインターフェース
 */
interface IScoutQueryParam
{
    public function __construct($include, $type, $value);
    public function makeQuery(Event $query, $value);
    public function formatValue($value);
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
        'or' => 'orWhere',
        'not' => 'whereNotIn',
    ];
    public $rangeConditionMaps = [
        'and' => 'whereBetweenEx',
        'or' => 'orWhereBetweenEx',
        'not' => 'whereNotBetweenEx',
    ];

    public function __construct($include, $type, $value)
    {
        $this->include = $include;
        $this->type = $type;
        $this->value = $value;
    }

    public function makeQuery($query, $value)
    {
        if (is_array($value) && count($value) == 2) {
            $method = $this->rangeConditionMaps[$this->include];
            $query = $this->$method($query, $this->column, $value);
        } else {
            $method = $this->conditionMaps[$this->include];
            $query->$method($this->column, $value);
        }
        return $query;
    }


    /**
     * 指定されたカラムの値が指定された範囲内にあるレコードを検索します。
     * FIXME:ハックを使用して実装
     * https://stackoverflow.com/questions/73186032/laravel-scout-with-meilisearch-filtering-not-working-with-and-opera
     *
     * @param \Laravel\Scout\Builder $query Scoutクエリビルダーインスタンス
     * @param string $column 検索対象のカラム名
     * @param array $values 範囲を指定する値の配列（最初の要素が下限、2番目の要素が上限）
     * @return \Laravel\Scout\Builder 範囲条件を適用したScoutクエリビルダーインスタンス
     */
    private function whereBetweenEx($query, $column, array $values)
    {
        $query->where($column . '>', $values[0]);
        $query->where($column . '<', $values[1]);
        // $query->where('good_count' . '>', 3);
        // $query->where('good_count' . '<', 9);
        return $query;
    }

    /**
     * 既存のクエリ条件に加えて、指定されたカラムの値が指定された範囲内にあるレコードを検索します。
     * FIXME:ハックを使用して実装
     * https://stackoverflow.com/questions/73186032/laravel-scout-with-meilisearch-filtering-not-working-with-and-opera
     *
     * @param \Laravel\Scout\Builder $query Scoutクエリビルダーインスタンス
     * @param string $column 検索対象のカラム名
     * @param array $values 範囲を指定する値の配列（最初の要素が下限、2番目の要素が上限）
     * @return \Laravel\Scout\Builder 範囲条件を適用したScoutクエリビルダーインスタンス
     */
    private function orWhereBetweenEx($query, $column, array $values)
    {
        $query->where($column . '>', $values[0]);
        $query->where($column . '<', $values[1]);
        return $query;
    }

    /**
     * 指定されたカラムの値が指定された範囲外にあるレコードを検索します。
     * FIXME:ハックを使用して実装
     * https://stackoverflow.com/questions/73186032/laravel-scout-with-meilisearch-filtering-not-working-with-and-opera
     *
     * @param \Laravel\Scout\Builder $query Scoutクエリビルダーインスタンス
     * @param string $column 検索対象のカラム名
     * @param array $values 範囲を指定する値の配列（最初の要素が下限、2番目の要素が上限）
     * @return \Laravel\Scout\Builder 範囲条件を適用したScoutクエリビルダーインスタンス
     */
    private function whereNotBetweenEx($query, $column, array $values)
    {
        $query->where($column . '<', $values[0]);
        $query->where($column . '>', $values[1]);
        return $query;
    }
}

/**
 * 日付クエリパラメータクラス
 */
class DateScoutQueryParam  extends ScoutQueryParam implements IScoutQueryParam
{
    protected $column = 'start_date';

    public function formatValue($value)
    {
        if (is_string($value) && strpos($value, '~') !== false) {
            [$start, $end] = explode('~', $value);
            return [Carbon::parse($start)->getTimestamp(), Carbon::parse($end)->getTimestamp()];
        }
        return $value;
    }
}

/**
 * ステータスクエリパラメータクラス
 */
class StatusScoutQueryParam  extends ScoutQueryParam implements IScoutQueryParam
{
    protected $column = 'status_label';

    public function formatValue($value)
    {
        return $value;
    }
}

/**
 * タグクエリパラメータクラス
 */
class TagScoutQueryParam extends ScoutQueryParam implements IScoutQueryParam
{
    protected $column = 'tags';

    public function formatValue($value)
    {
        return $value;
    }
}

/**
 * カテゴリクエリパラメータクラス
 */
class CategoryScoutQueryParam extends ScoutQueryParam implements IScoutQueryParam
{
    protected $column = 'categories';

    public function formatValue($value)
    {
        return $value;
    }
}
/**
 * ユーザークエリパラメータクラス
 */
class UsrerScoutQueryParam extends ScoutQueryParam implements IScoutQueryParam
{
    protected $column = 'categories';

    public function formatValue($value)
    {
        return $value;
    }
}
