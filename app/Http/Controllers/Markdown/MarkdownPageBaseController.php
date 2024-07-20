<?php

namespace App\Http\Controllers\Markdown;

use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class MarkdownPageBaseController extends Controller
{
    protected function getPage($category, $page)
    {
        $viewPath = "markdown.{$category}.{$page}";

        if (! View::exists($viewPath)) {
            abort(404);
        }

        // Bladeテンプレートをコンパイルして内容を取得
        $content = view($viewPath)->render();

        return Inertia::render('Markdown/Index', [
            'title' => $page,
            'content' => Str::markdown($content),
        ]);
    }
}
