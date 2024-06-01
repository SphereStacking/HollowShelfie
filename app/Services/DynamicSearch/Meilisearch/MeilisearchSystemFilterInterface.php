<?php

namespace App\Services\DynamicSearch\Meilisearch;

/**
 * クエリパラメータインターフェース
 */
interface MeilisearchSystemFilterInterface
{
    public function makeQuery();
}
