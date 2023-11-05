<?php

namespace App\Services;

use App\Models\Tag;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\EventTag;
use App\Enums\EventStatus;
use Illuminate\Support\Facades\Auth;
use App\Services\FileService;

class EventService
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    // /Eventのindexページの要素を返す
    public function getSectionEvents()
    {
        return [
            'newEvents' => $this->getSectionedQuery('new')->take(4)->get(),
            'ongoingEvents' => $this->getSectionedQuery('ongoing')->take(4)->get(),
            'highlightEvents' => $this->getSectionedQuery('highlight')->take(4)->get(),
            'recentEvents' => $this->getSectionedQuery('recent')->take(4)->get(),
            'myLikeEvents' => $this->getSectionedQuery('mylike')->take(4)->get(),
            'myOrganizerEvents' => $this->getSectionedQuery('myorganizer')->take(4)->get(),
        ];
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

    // /Event/Listのindexページの要素を返す
    public function getEventList($section, $tags = null, $paginate = 10)
    {

        $trendTags = $this->getTrendTagNames();
        $events = $this->getSectionedQuery($section)
            ->filterByTags($tags)
            ->paginate($paginate);
        return [
            'trendTags' => $trendTags,
            'events' => $events
        ];
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



    //人気のタグを探して取得し
    //nameだけを抽出して返す。
    public function getTrendTagNames()
    {
        $popularTagIds = EventTag::popularTags()
            ->limit(4)
            ->pluck('tag_id');
        return Tag::whereIn('id', $popularTagIds)->pluck('name');
    }

    //
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
            case 'mylike':
                return $this->getMyLikeEventsQuery();
            case 'myorganizer':
                return $this->getMyOrganizerEventsQuery();
            default:
                return $this->getNewEventsQuery();
        }
    }


    // public function getPublicRelationsEvents()
    // {
    //     return Event::where('status', [EventStatus::PUBLISHED,])
    //         ->orderBy('created_at', 'asc');
    // }
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
        return Event::where('status', [EventStatus::UPCOMING]);
    }

    private function getMyLikeEventsQuery()
    {
        return Event::whereIn('status', [EventStatus::ONGOING, EventStatus::UPCOMING])
            ->whereHas('like_users', function ($query) {
                $query->where('user_id', Auth::user()->id);
            });
    }

    private function getMyOrganizerEventsQuery()
    {
        return Event::where('user_id', Auth::user()->id);
    }
}
