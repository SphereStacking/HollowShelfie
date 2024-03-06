<?php

namespace App\Http\Controllers\Markdown;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class MarkdownPageBaseController extends Controller
{
    protected function getPage($category, $page)
    {
        if (!File::exists(resource_path("markdown/{$category}/{$page}.md"))) {
            abort(404);
        }

        $content = File::get(resource_path("markdown/{$category}/{$page}.md"));
        return Inertia::render('Markdown/Index', [
            'content' => Str::markdown($content),
        ]);
    }
}
