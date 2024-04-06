<?php

namespace App\Services;

use App\Enums\EventStatus;
use App\Exceptions\CannotOperateEventException;
use App\Exceptions\EventNotPublishedException;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventService
{
    protected FileService $fileService;

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
        $attributes = [
            'title' => '',
            'categories' => [],
            'tags' => [],
            'description' => '',
            'dates' => [],
            'organizers' => [],
            'performers' => [],
            'time_tables' => [],
            'status' => EventStatus::DRAFT,
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
            $event->syncCategoriesByNames($attributes['categories'] ?? []);
            $event->syncOrganizers($attributes['organizers'] ?? []);
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
    public function updateEventByAlias(string $alias, array $attributes)
    {
        DB::beginTransaction();
        try {
            $event = self::findOrFailByAlias($alias);
            if (! $event->canUserOperate(Auth::user())) {
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
            $event->syncCategoriesByNames($attributes['categories'] ?? []);
            $event->syncOrganizers($attributes['organizers'] ?? []);
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
            'event_time_tables.performers.performable',
        ])->find($id);

        if (! $event) {
            throw new ModelNotFoundException('Eventが見つかりませんでした。');
        }
        $user = Auth::user();

        // イベントが未公開（公開日が未来）かつログインユーザーがイベントの作成者でない場合、エラーを投げる
        if (
            isset($event->published_at) &&
            $event->published_at->isFuture() &&
            $event->event_create_user_id !== $user?->id
        ) {
            throw new EventNotPublishedException('イベントはまだ公開されていません。');
        }

        $this->viewCountService->incrementCount($event);

        return $event;

    }


    /**
     * イベントをリレーション含めて詳細を取得する。
     */
    public function getEventDetailByAlias($alias)
    {
        $event = Event::with([
            'organizers.event_organizeble',
            'event_time_tables.performers.performable',
        ])->where('alias', $alias)->first();

        if (! $event) {
            throw new ModelNotFoundException('Eventが見つかりませんでした。');
        }
        $user = Auth::user();

        // イベントが未公開（公開日が未来）かつログインユーザーがイベントの作成者でない場合、エラーを投げる
        if (!$event->canUserShow($user)) {
            throw new EventNotPublishedException('イベントはまだ公開されていません。');
        }

        $this->viewCountService->incrementCount($event);

        return $event;
    }

    /**
     * イベントを取得する。
     */
    public function getEventByAlias($alias)
    {
        $event = Event::where('alias', $alias)->first();

        if (! $event) {
            throw new ModelNotFoundException('Eventが見つかりませんでした。');
        }
        $user = Auth::user();
        if (!$event->canUserShow($user)) {
            throw new EventNotPublishedException('イベントはまだ公開されていません。');
        }

        $this->viewCountService->incrementCount($event);

        return $event;
    }

    /**
     * 内部参照用
     * イベント取得
     */
    private function findOrFailByAlias($alias): Event
    {
        return Event::where('alias', $alias)->firstOrFail();
    }

    //イベントを削除する。
    public function deleteEvent(string $alias): void
    {
        DB::beginTransaction();
        try {
            $event = self::findOrFailByAlias($alias);
            if (! $event->canUserOperate(Auth::user())) {
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
     * @param  User  $user ユーザーインスタンス
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

    public function getPublicRandomEvents($limit = 3, $status = null)
    {
        $status = $status ?? EventStatus::PUBLIC_SEARCH_STATUSES;

        return Event::where('published_at', '<=', Carbon::now())
            ->whereIn('status', $status)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }
}
