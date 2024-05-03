<?php

namespace App\Http\Controllers\Markdown;

class GetCreditPageController extends MarkdownPageBaseController
{
    public function __invoke()
    {
        return $this->getPage('credit', 'credit');
    }
}
