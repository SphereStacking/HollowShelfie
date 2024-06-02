<?php

namespace App\Services\DynamicSearch\Meilisearch;

/**
 * クエリパラメータ抽象クラス
 */
abstract class MeilisearchSystemFilter implements MeilisearchSystemFilterInterface
{
    abstract public function makeQuery();
}
