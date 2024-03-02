<?php

namespace App\Http\Controllers\Event;

use Inertia\Inertia;
use App\Models\Event;
use Inertia\Response;
use App\Models\Category;
use App\Models\InstanceType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\InstanceTypeResource;
use App\Http\Resources\EventEditJsonResource;

class GetEditEventController extends Controller
{
    public function __invoke(Event $event): Response
    {
        if (!$event->canUserOperate(Auth::user())) {
            throw new CannotOperateEventException();
        }
        return Inertia::render('Event/Edit', [
            'categories'=> CategoryResource::collection(Category::all()),
            'instanceTypes'=> InstanceTypeResource::collection(InstanceType::all()),
            'event' => new EventEditJsonResource($event),
        ]);
    }
}
