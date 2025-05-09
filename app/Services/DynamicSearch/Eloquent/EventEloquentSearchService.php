<?php

namespace App\Services;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\User;
use App\Params\EventEloquentSearchParams;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * イベント検索サービス
 */
class EventEloquentSearchService
{
    /**
     * クエリパラメータクラス
     *
     * @var array
     */
    private $queryParamClasses = [
        'date' => DateQueryParam::class,
        'status' => StatusQueryParam::class,
        'tag' => TagQueryParam::class,
        'category' => CategoryQueryParam::class,
    ];

    /**
     * オーダースコープ
     *
     * @var array
     */
    private $orderScopes = [
        'good' => 'orderByGoodUserCount',
        'new' => 'orderByNewest',
        'view' => 'orderByViews',   // TODO:いつかやろうね
        'trend' => 'orderByTrendiness', // TODO:いつかやろうね
    ];

    /**
     * Userイベント検索を取得
     */
    public function getEventSearchByUser(User|Authenticatable $user, EventEloquentSearchParams $params): LengthAwarePaginator
    {
        $query = $user->create_events();

        $query->where('title', 'like', "%{$params->text}%");

        $queryParams = [];
        foreach ($params->queryParams as $item) {
            $type = $item['type'];
            if (array_key_exists($type, $this->queryParamClasses)) {
                $class = $this->queryParamClasses[$type];
                $queryParams[] = new $class($item['include'], $type, $item['value']);
            }
        }

        //動的に生成してqueryを追加
        foreach ($queryParams as $item) {
            $value = $item->formatValue($item->value);
            $item->makeQuery($query, $value);
        }

        //オーダー指定がある場合は適用
        if (array_key_exists($params->order, $this->orderScopes)) {
            $scopeMethod = $this->orderScopes[$params->order];
            $query->$scopeMethod();
        }

        return $query
            ->paginate($params->paginate)
            ->withQueryString();
    }

    /**
     * 公開イベント検索を取得
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPublishedEventSearch(Event $query, EventEloquentSearchParams $params)
    {

        $queryParams = [];
        $params->text = $params->text ?? '';

        foreach ($params->queryParams as $item) {
            $type = $item['type'];
            if (array_key_exists($type, $this->queryParamClasses)) {
                $class = $this->queryParamClasses[$type];
                $queryParams[] = new $class($item['include'], $type, $item['value']);
            }
        }

        //動的に生成してqueryを追加
        foreach ($queryParams as $item) {
            $value = $item->formatValue($item->value);
            $item->makeQuery($query, $value);
        }

        //オーダー指定がある場合は適用
        if (array_key_exists($params->order, $this->orderScopes)) {
            $scopeMethod = $this->orderScopes[$params->order];
            $query->$scopeMethod();
        }

        return $query
            ->generalPublished()
            ->paginate($params->paginate)
            ->withQueryString();
    }
}

/**
 * クエリパラメータインターフェース
 */
interface IQueryParam
{
    public function __construct($include, $type, $value);

    public function makeQuery(Event $query, $value);

    public function formatValue($value);

    public function getRelation();
}

/**
 * クエリパラメータ抽象クラス
 */
abstract class QueryParam
{
    protected $relation = null;

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
        'and' => 'whereBetween',
        'or' => 'orWhereBetween',
        'not' => 'whereNotBetween',
    ];

    public function __construct($include, $type, $value)
    {
        $this->include = $include;
        $this->type = $type;
        $this->value = $value;
    }

    public function getRelation()
    {
        return $this->relation;
    }

    public function makeQuery($query, $value)
    {
        $method = $this->getMethod($value);

        return $this->relation
            ? $this->makeQueryWithRelation($query, $method, $value)
            : $this->makeQueryWithoutRelation($query, $method, $value);
    }

    private function getMethod($value)
    {
        if (is_array($value) && count($value) == 2) {
            return $this->rangeConditionMaps[$this->include];
        } else {
            return $this->conditionMaps[$this->include];
        }
    }

    private function makeQueryWithRelation($query, $method, $value)
    {
        $query->whereHas($this->relation, function ($query) use ($method, $value) {
            $query->$method($this->column, $value);
        });

        return $query;
    }

    private function makeQueryWithoutRelation($query, $method, $value)
    {
        $query->$method($this->column, $value);

        return $query;
    }
}

/**
 * 日付クエリパラメータクラス
 */
class DateQueryParam extends QueryParam implements IQueryParam
{
    protected $column = 'start_date';

    public function formatValue($value)
    {
        if (is_string($value) && mb_strpos($value, '~') !== false) {
            [$start, $end] = explode('~', $value);

            return [$start, $end];
        }

        return $value;
    }
}

/**
 * ステータスクエリパラメータクラス
 */
class StatusQueryParam extends QueryParam implements IQueryParam
{
    protected $column = 'status';

    public function formatValue($value)
    {
        return EventStatus::getRawStatus($value);
    }
}

/**
 * タグクエリパラメータクラス
 */
class TagQueryParam extends QueryParam implements IQueryParam
{
    protected $relation = 'tags';

    protected $column = 'name';

    public function formatValue($value)
    {
        return $value;
    }
}

/**
 * カテゴリクエリパラメータクラス
 */
class CategoryQueryParam extends QueryParam implements IQueryParam
{
    protected $relation = 'categories';

    protected $column = 'name';

    public function formatValue($value)
    {
        return $value;
    }
}
