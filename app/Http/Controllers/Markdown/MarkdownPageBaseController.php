<?php

namespace App\Http\Controllers\Markdown;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Inertia\Inertia;

class MarkdownPageBaseController extends Controller
{
    protected function getPage($category, $page)
    {
        if (! File::exists(resource_path("markdown/{$category}/{$page}.md"))) {
            abort(404);
        }

        $content = File::get(resource_path("markdown/{$category}/{$page}.md"));

        return Inertia::render('Markdown/Index', [
            'title' => $page,
            'content' => Str::markdown($content),
        ]);
    }
}
