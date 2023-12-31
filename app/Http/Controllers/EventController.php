<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventShowJsonResource;
use App\Services\EventMeilisearchService;

class EventController extends Controller
{
    protected $eventService;
    protected $eventMeilisearchService;

    public function __construct(
        EventService $eventService,
        EventMeilisearchService $eventMeilisearchService
    ) {
        $this->eventService = $eventService;
        $this->eventMeilisearchService = $eventMeilisearchService;
    }

    /**
     * イベント一覧を表示。
     *
     * @return \Inertia\Response
     */
    public function index()
    {

        return Inertia::render(
            'Event/Index',
            []
        );
    }

    /**
     * イベントをタイムライン表示する。
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function timeline(Request $request)
    {
        $section = $request->input('section');
        $tags = $request->input('tags');
        $per_page = $request->input('per_page', 24);

        return Inertia::render(
            'Event/Timeline',
            $this->eventService->getEventList($section, $tags, $per_page)
        );
    }

    /**
     * 新規イベント作成のフォームを表示。
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Event/Create');
    }

    /**
     * 新規イベントを保存。
     *
     * @param EventRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EventRequest $request)
    {
        $Attributes = $request->only([
            'title',
            'description',
            'performers',
            'flyer',
            'date',
            'dates'
        ]);

        $flyers = $request->only([
            'flyers',
        ]);

        $this->eventService->storeEvent($Attributes, $flyers);

        return redirect()->route('event.index')->with([
            'status' => 'success',
            'message' => 'イベントを登録しました。'
        ]);
    }

    /**
     * 指定したイベントを更新。
     *
     * @param EventRequest $request
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EventRequest $request, Event $event)
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

    /**
     * 指定したイベントを閲覧。
     *
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        return Inertia::render('Event/Show', [
            'event' => new EventShowJsonResource($this->eventService->getShowEvent($id)),
            'recommendEvents' => $this->eventService->getRecommendEvent(),
            'trendTags' => $this->eventService->getTrendTagNames()
        ]);
    }

    /**
     * 指定したイベントを削除。
     *
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with([
            'status' => 'success',
            'message' => 'イベントにいいねしました。'
        ]);
    }

}
