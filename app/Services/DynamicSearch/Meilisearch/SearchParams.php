<?php

namespace App\Services\DynamicSearch\Meilisearch;

class SearchParams
{
    protected int $defaultPaginate = 32;

    protected string $defaultOrder = 'new';

    public string $text;

    public array $queryParams;

    public int $paginate;

    public string $order;

    public function __construct(
        ?string $text = '',
        ?array $queryParams = [],
        int $paginate = null,
        string $order = null
    ) {
        $this->text = $text ?? '';
        $this->queryParams = $queryParams ?? [];
        $this->paginate = $paginate ?? $this->defaultPaginate;
        $this->order = $order ?? $this->defaultOrder;
    }

    public function getDefaultPaginate(): int
    {
        return $this->defaultPaginate;
    }

    public function __toString()
    {
        return json_encode($this);
    }
}
