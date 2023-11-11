<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MarkdownPageController extends Controller
{
    public function showAbout($page)
    {
        return $this->show('about', $page);
    }

    public function showGuides($page)
    {
        return $this->show('guide', $page);
    }

    public function showLegal($page)
    {
        return $this->show('legal', $page);
    }

    private function show($category, $page)
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
