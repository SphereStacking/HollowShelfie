<?php

namespace App\Services\DynamicSearch\Meilisearch;

/**
 * クエリパラメータインターフェース
 */
interface MeilisearchFilterInterface
{
    public function __construct($include, $type, $value, $isFirst);

    public function makeQuery();

    public function formatValue();
}
