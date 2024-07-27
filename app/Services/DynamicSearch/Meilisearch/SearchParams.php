<?php

namespace App\Services\DynamicSearch\Meilisearch;

class SearchParams
{
    protected const DEFAULT_PAGINATE = 32;
    protected const DEFAULT_ORDER = 'new';
    protected const DEFAULT_DIRECTION = 'default';

    public string $text;
    public array $queryParams;
    public int $paginate;
    public string $order;
    public ?string $direction;

    public function __construct(
        ?string $text = '',
        ?array $queryParams = [],
        ?int $paginate = self::DEFAULT_PAGINATE,
        ?string $order = self::DEFAULT_ORDER,
        ?string $direction = self::DEFAULT_DIRECTION
    ) {
        $this->text = $text ?? '';
        $this->queryParams = $queryParams ?? [];
        $this->paginate = $paginate ?? self::DEFAULT_PAGINATE;
        $this->order = $order ?? self::DEFAULT_ORDER;
        $this->direction = $direction ?? self::DEFAULT_DIRECTION;
    }

    public function getDefaultPaginate(): int
    {
        return self::DEFAULT_PAGINATE;
    }

    public function __toString()
    {
        return json_encode($this);
    }
}
