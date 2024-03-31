<?php

namespace App\Http\Controllers\Markdown;

class GetLegalPageController extends MarkdownPageBaseController
{
    public function __invoke($page)
    {
        return $this->getPage('legal', $page);
    }
}
