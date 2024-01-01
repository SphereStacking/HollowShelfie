<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Tag;
use Inertia\Inertia;
use App\Models\Event;
use App\Enums\EventStatus;
use App\Services\FileService;
use App\Services\ViewCountService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EventService
{
    protected FileService  $fileService;
    protected ViewCountService $viewCountService;

    public function __construct(
        FileService $fileService,
        ViewCountService $viewCountService
    ) {
        $this->fileService = $fileService;
        $this->viewCountService = $viewCountService;
    }

    //イベントを作成する。
    public function storeEvent($attributes, $uploadedFiles)
    {
        $event = Event::create($attributes)->get();
        // ファイルアップロードのロジックはFileServiceに委譲
        foreach ($uploadedFiles as $file) {
            $this->fileService->uploadFile($file, $event);
        }
        return Event::create($attributes);
    }

    //イベントを取得する。
    public function getShowEvent($id)
    {
        $event = Event::with([
            'organizers.event_organizeble',
            'event_time_tables.performers.performable' // UserまたはTeamのデータも併せて取得
        ])->find($id);
        $this->viewCountService->incrementCount($event);
        return $event;
    }

    // /Event/Listのindexページの要素を返す
    public function getEventList($section, $tags = null, $paginate = 10)
    {
        return $this->getSectionedQuery($section)
            ->filterByTags($tags)
            ->paginate($paginate);
    }

    // 引数で渡されたイベントと似たイベント抽出する。
    public function getrelatedEvent($event)
    {
        // TODO:いったん新しいのでよいかも
        return $this->getNewEventsQuery()->take(4)->get();
    }
    // 引数で渡されたイベントと似たイベント抽出する。
    public function getRecommendEvent()
    {
        // TODO:いったん新しいのでよいかも
        return $this->getNewEventsQuery()->take(4)->get();
    }



    private function getSectionedEvents($section, $tags = null, $per_page = 12)
    {
        $maxPaginate = 120; // 許可する最大のページネーション数
        $actualPaginate = min($per_page, $maxPaginate); // 実際に使用するページネーション数
        $query = $this->getSectionedQuery($section);
        if ($tags) {
            $query->filterByTags($tags);
        }
        $query->paginate($actualPaginate);
        return $query->get();
    }

    public function getSectionedQuery($section = '')
    {
        switch (strtolower($section)) {
            case 'new':
                return $this->getNewEventsQuery();
            case 'ongoing':
                return $this->getOngoingEventsQuery();
            case 'highlight':
                return $this->getHighlightEventsQuery();
            case 'recent':
                return $this->getRecentEventsQuery();
            case 'mybookmark':
                return $this->getMyBookmarkEventsQuery();
            default:
                return $this->getNewEventsQuery();
        }
    }

    private function getPublishedEventsQuery()
    {
        return Event::where('status', [EventStatus::ONGOING, EventStatus::UPCOMING, EventStatus::CLOSED]);
    }

    private function getNewEventsQuery()
    {
        return Event::where('status', [EventStatus::UPCOMING])
            ->orderBy('created_at', 'asc');
    }

    private function getOngoingEventsQuery()
    {
        return Event::where('status', EventStatus::ONGOING);
    }

    private function getHighlightEventsQuery()
    {
        return Event::where('status', [EventStatus::ONGOING, EventStatus::UPCOMING]);
    }

    private function getRecentEventsQuery()
    {
        return Event::where('status', [EventStatus::UPCOMING])
            ->where('start_date', '>=', Carbon::now())
            ->orderBy('start_date', 'asc');
    }

    private function getMyBookmarkEventsQuery()
    {
        $user = Auth::user();

        if (!$user) {
            return Event::query(); // ログインしていない場合は空のクエリを返す
        }

        return Event::whereIn('status', [EventStatus::ONGOING, EventStatus::UPCOMING])
            ->whereHas('bookmark_users', function ($query) {
                $query->where('user_id', Auth::user()->id);
            });
    }
}
