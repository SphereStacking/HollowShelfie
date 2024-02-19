<?php

namespace App\Http\Controllers\Event;

use Inertia\Inertia;
use App\Models\Event;
use Inertia\Response;
use App\Models\Category;
use App\Models\InstanceType;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\InstanceTypeResource;
use App\Http\Resources\EventEditJsonResource;

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
