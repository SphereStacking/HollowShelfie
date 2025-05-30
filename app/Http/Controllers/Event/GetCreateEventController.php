<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Services\EventService;
use Illuminate\Http\RedirectResponse;

class GetCreateEventController extends Controller
{
    public function __construct(
        private readonly EventService $eventService,
    ) {
    }

    public function __invoke(): RedirectResponse
    {
        $event = $this->eventService->initCreateEvent();

        //画像UPする関係で事前にEventを生成しておく必要があるため
        //Eventを初期状態で生成し編集画面を返す。
        return redirect()->route('event.edit', $event->alias);
    }
}
