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

class UpdateEventController extends Controller
{
    public function __invoke(Event $event, Request $request): \Illuminate\Http\RedirectResponse
    {
        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'logo_path' => $request->file('logo_path') ? $request->file('logo_path')->store('events') : $event->logo_path,
            'flyer_path' => $request->file('flyer_path') ? $request->file('flyer_path')->store('events') : $event->flyer_path,
        ]);

        return redirect()->route('events.index')->with([
            'status' => 'success',
            'message' => 'イベントにいいねしました。'
        ]);
    }
}
