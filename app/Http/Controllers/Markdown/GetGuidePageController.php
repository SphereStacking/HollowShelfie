<?php

namespace App\Http\Controllers\Markdown;

class GetGuidePageController extends MarkdownPageBaseController
{
    public function __invoke($page)
    {
        return $this->getPage('guide', $page);
    }
}
