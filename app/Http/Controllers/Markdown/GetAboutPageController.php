<?php

namespace App\Http\Controllers\Markdown;

class GetAboutPageController extends MarkdownPageBaseController
{
    public function __invoke($page)
    {
        return $this->getPage('about', $page);
    }
}
