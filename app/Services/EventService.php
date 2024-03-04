<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Event;
use App\Enums\EventStatus;
use App\Services\FileService;
use App\Services\ViewCountService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\EventNotPublishedException;
use App\Exceptions\CannotOperateEventException;

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

    public function initCreateEvent()
    {
        $attributes= [
            'title' => '',
            'categories' => [],
            'tags' =>  [],
            'description' => '',
            'dates' => [],
            'organizers' =>  [],
            'performers' =>[],
            'time_tables' =>  [],
            'status' =>  EventStatus::DRAFT,
            'images' => [],
            'instances' => [],
        ];

        return $this->createEvent($attributes);
    }

    //イベントを作成する。
    public function createEvent($attributes)
    {
        DB::beginTransaction();
        try {
            Log::debug($attributes);

            $event = new Event;
            $event->title = $attributes['title'];
            $event->description = $attributes['description'];
            $event->start_date = $attributes['dates'][0] ?? null;
            $event->end_date = $attributes['dates'][1] ?? null;
            $event->event_create_user_id = Auth::user()->id;
            $event->updateEventStatus($attributes['status'] ?? EventStatus::DRAFT);
            $event->save();

            $event->syncTagsByNames($attributes['tags'] ?? []);
            $event->syncCategoriesByNames($attributes['categories']?? []);
            $event->syncOrganizers($attributes['organizers']?? []);
            $event->syncTimeTables($attributes['time_tables'] ?? []);
            $event->syncInstances($attributes['instances'] ?? []);

            DB::commit();

            return $event;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    //イベントを更新する。
    public function updateEvent($id,$attributes)
    {
        DB::beginTransaction();
        try {
            Log::debug($attributes);
            $event = Event::findOrFail($id);
            if (!$event->canUserOperate(Auth::user())) {
                throw new CannotOperateEventException();
            }
            $event->title = $attributes['title'];
            $event->description = $attributes['description'];
            $event->start_date = $attributes['dates'][0] ?? null;
            $event->end_date = $attributes['dates'][1] ?? null;
            $event->event_create_user_id = Auth::user()->id;
            $event->updateEventStatus($attributes['status'] ?? EventStatus::DRAFT);
            $event->save();

            $event->syncTagsByNames($attributes['tags'] ?? []);
            $event->syncCategoriesByNames($attributes['categories']?? []);
            $event->syncOrganizers($attributes['organizers']?? []);
            $event->syncTimeTables($attributes['time_tables'] ?? []);
            $event->syncInstances($attributes['instances'] ?? []);

            DB::commit();

            return $event;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    //イベントを取得する。
    public function getShowEvent($id)
    {
        $event = Event::with([
            'organizers.event_organizeble',
            'event_time_tables.performers.performable'
        ])->find($id);

        $user = Auth::user();

        // イベントが未公開（公開日が未来）かつログインユーザーがイベントの作成者でない場合、エラーを投げる
        $isUnpublished = isset($event->published_at) && $event->published_at->isFuture();
        $isNotCreator = $event->event_create_user_id !== $user->id;
        if ($isUnpublished && $isNotCreator) {
            throw new EventNotPublishedException('The event is not published yet.');
        }

        $this->viewCountService->incrementCount($event);
        return $event;

    }

    //イベントを削除する。
    public function deleteEvent($id)
    {
        DB::beginTransaction();
        try {
            $event = Event::findOrFail($id);
            if (!$event->canUserOperate(Auth::user())) {
                throw new CannotOperateEventException();
            }
            $event->delete();
            DB::commit();
        } catch (CannotOperateEventException $e) {
            DB::rollBack();
            Log::warning($e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * 指定されたユーザーがオーガナイザーになっているイベントをページネーション付きで取得
     *
     * @param User $user ユーザーインスタンス
     * @return \Illuminate\Pagination\LengthAwarePaginator ページネーションされたイベント
     */
    public function getPaginatedEventsForOrganizer(User $user)
    {
        $paginatedEventOrganizers = $user->event_organizers()->paginate(10);

        // ページネーションされたコレクションからイベントデータを抽出
        $events = $paginatedEventOrganizers->getCollection()->map(function ($eventOrganizer) {
            return $eventOrganizer->event;
        });

        // ページネーション情報を保持しつつ、イベントデータのみを更新
        $paginatedEventOrganizers->setCollection($events);

        return $paginatedEventOrganizers;
    }



}
