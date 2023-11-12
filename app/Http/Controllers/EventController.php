<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use Inertia\Inertia;
use App\Models\Event;
use App\Enums\EventStatus;
use Illuminate\Http\Request;
use App\Services\EventService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EventRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\EventsJsonResource;
use App\Http\Resources\EventShowJsonResource;


class EventController extends Controller
{
    protected $eventService;
    protected $eventTagService;

    public function __construct(
        EventService $eventService,
    ) {
        $this->eventService = $eventService;
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
            [
                'newEvents' => new EventsJsonResource($this->eventService->getSectionedQuery('new')->take(4)->get()),
                'ongoingEvents' => new EventsJsonResource($this->eventService->getSectionedQuery('ongoing')->take(4)->get()),
                'highlightEvents' => new EventsJsonResource($this->eventService->getSectionedQuery('highlight')->take(4)->get()),
                'recentEvents' => new EventsJsonResource($this->eventService->getSectionedQuery('recent')->take(4)->get()),
                'myBookmarkEvents' => new EventsJsonResource($this->eventService->getSectionedQuery('mybookmark')->take(4)->get()),
            ]
        );
    }

    /**
     * 全てのイベントを表示。
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function list(Request $request)
    {
        $section = $request->input('section');
        $tags = $request->input('tags');
        $per_page = $request->input('per_page', 24);

        return Inertia::render(
            'Event/List/Index',
            [
                'trendTags' => $this->eventService->getTrendTagNames(),
                'events' => $this->eventService->getEventList($section, $tags, $per_page)
            ]
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

    /**
     * 指定したイベントの「いいね」状態を切り替え。
     *
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleEventGood(Event $event)
    {
        $user = Auth::user();
        if ($user->good_events->contains($event->id)) {
            // いいねを取り消す
            $user->good_events()->detach($event->id);
            return Redirect::back()->with([
                'status' => 'success',
                'message' => 'イベントのいいねを取り消しました。'
            ]);
        }

        // イベントに「いいね」を追加
        $user->good_events()->attach($event->id);
        return Redirect::back()->with([
            'status' => 'success',
            'message' => 'イベントにいいねしました。'
        ]);
    }

    /**
     * 指定したイベントの「ライク」状態を切り替え。
     *
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleEventBookmark(Event $event)
    {
        $user = Auth::user();
        if ($user->bookmark_events->contains($event->id)) {
            // いいねを取り消す
            $user->bookmark_events()->detach($event->id);
            return Redirect::back()->with([
                'status' => 'success',
                'message' => 'イベントにいいねしました。'
            ]);
        }

        // イベントに「いいね」を追加
        $user->bookmark_events()->attach($event->id);
        return Redirect::back()->with([
            'status' => 'success',
            'message' => 'イベントにいいねしました。'
        ]);
    }
}
