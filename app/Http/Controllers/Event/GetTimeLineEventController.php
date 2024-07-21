<?php

namespace App\Http\Controllers\Event;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Event;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventTimelineJsonResource;

class GetTimeLineEventController extends Controller
{
    public function __invoke(Request $request): Response
    {
        // リクエストから開始日と終了日を取得、もしくはデフォルト値を設定
        $startDate = $request->has('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->subHours(3);
        $endDate = $request->has('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now()->addDays(7);

        // 指定された日付範囲でイベントを取得
        $events = Event::with(['event_time_tables.performers.performable'])
            ->whereBetween('start_date', [$startDate, $endDate])
            ->generalPublished()
            ->get();

        return Inertia::render('Event/Timeline',[
                'events' => new EventTimelineJsonResource($events),
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]
        );
    }
}
