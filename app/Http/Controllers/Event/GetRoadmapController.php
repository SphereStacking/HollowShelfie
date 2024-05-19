<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventShowJsonResource;
use App\Services\EventService;
use App\Services\TagService;
use Inertia\Inertia;
use Inertia\Response;

class GetRoadmapController extends Controller
{
    public function __construct() {}

    public function __invoke(): Response
    {
        return Inertia::render('Roadmap/Index', []);
    }
}
