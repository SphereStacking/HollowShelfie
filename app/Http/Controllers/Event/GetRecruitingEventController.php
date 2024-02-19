<?php

namespace App\Http\Controllers\Event;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Category;
use App\Models\InstanceType;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\InstanceTypeResource;

class GetRecruitingEventController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Event/Recruiting');
    }
}
