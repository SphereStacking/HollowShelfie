<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GetTimeLineEventController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $section = $request->input('section');
        $tags = $request->input('tags');
        $per_page = $request->input('per_page', 24);

        return Inertia::render(
            'Event/Timeline',
            []
        );
    }
}
