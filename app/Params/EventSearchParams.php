<?php

namespace App\Params;


class EventSearchParams extends Params
{
    public string $text;
    public array $queryParams;
    public int $paginate;
    public string $order;

    public function __construct(?string $text, array $queryParams, int $paginate, ?string $order)
    {
        $this->text = $text ?? '';
        $this->queryParams = $queryParams;
        $this->paginate = $paginate;
        $this->order = $order ?? '';
    }
}
