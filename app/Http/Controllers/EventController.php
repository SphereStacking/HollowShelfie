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
            $this->eventService->getSectionEvents()
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
        $per_page
            = $request->input('per_page', 24);

        return Inertia::render(
            'Event/List/Index',
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
    public function show(Event $event)
    {
        return Inertia::render('Event/Show', [
            'event' => $event,
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
    public function toggleEventLike(Event $event)
    {
        $user = Auth::user();
        if ($user->like_events->contains($event->id)) {
            // いいねを取り消す
            $user->like_events()->detach($event->id);
            return Redirect::back()->with([
                'status' => 'success',
                'message' => 'イベントにいいねしました。'
            ]);
        }

        // イベントに「いいね」を追加
        $user->like_events()->attach($event->id);
        return Redirect::back()->with([
            'status' => 'success',
            'message' => 'イベントにいいねしました。'
        ]);
    }
}
