<?php

namespace App\Http\Controllers\Event;

use Exception;
use DateTimeZone;
use App\Services\EventService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EventDuplicateRequest;

class DuplicateEventController extends Controller
{
    public function __construct(
        private readonly EventService $eventService,
    ) {
    }

    public function __invoke(EventDuplicateRequest $request,$alias)
    {
        try{
            $attributes = $request->getAttributes();
            DB::beginTransaction();
            $event = $this->eventService->getEventDetailByAlias($alias);
            $event->canUserOperate(Auth::user());
            $duplicatedEvent = $event->duplicateEvent($attributes['title']);
            DB::commit();
            return redirect()->route('event.edit', $duplicatedEvent->alias);
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'イベントの複製に失敗しました');
        }
    }
}
