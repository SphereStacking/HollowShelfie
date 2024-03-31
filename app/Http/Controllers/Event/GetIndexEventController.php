<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class GetIndexEventController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Event/Index', [
        ]);
    }
}
