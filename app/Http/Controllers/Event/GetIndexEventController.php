<?php

namespace App\Http\Controllers\Event;

use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Controller;

class GetIndexEventController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Event/Index', [
        ]);
    }
}
