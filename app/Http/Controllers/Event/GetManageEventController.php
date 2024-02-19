<?php

namespace App\Http\Controllers\Event;

use Inertia\Inertia;
use App\Models\Event;
use Inertia\Response;
use App\Models\Category;
use App\Enums\EventStatus;
use App\Models\InstanceType;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Http\Requests\EventRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EventStoreRequest;
use App\Http\Resources\CategoryResource;
use App\Services\EventMeilisearchService;
use App\Http\Resources\InstanceTypeResource;
use App\Http\Resources\EventListJsonResource;
use App\Http\Resources\EventShowJsonResource;

class GetManageEventController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $user = Auth::user();
        $events =  $user->create_events()->paginate(10);

        return Inertia::render('Event/EventManage', [
            'events' => new EventListJsonResource($events),
        ]);
    }
}
