<?php

namespace App\Services\DynamicSearch\Meilisearch;

/**
 * クエリパラメータインターフェース
 */
interface MeilisearchFilterInterface
{
    public function __construct($include, $type, $value);

    public function makeQuery();

    public function formatValue();
}
