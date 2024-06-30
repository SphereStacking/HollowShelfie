<?php

namespace App\Models;

use Exception;
use Carbon\Carbon;
use App\Enums\EventStatus;
use App\Traits\HasFileable;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use App\Models\Traits\EventScopes;
use App\Models\Traits\EventGetters;
use App\Models\Traits\EventSetters;
use Illuminate\Support\Facades\Log;
use App\Models\Traits\EventRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Exceptions\EventNotPublishedException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use EventGetters;
    use EventRelations;
    use EventScopes;
    use EventSetters;
    use HasFactory;
    use HasFileable;
    use Searchable;
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'published_at',
        'is_forced_hidden',
        'title',
        'created_user_id',
        'start_date',
        'end_date',
        'description',
        'alias',
    ];

    /**
     * @var array<int, string>
     */
    protected $appends = [
        'created_user',
        'is_bookmark', 'is_good', 'category_name', 'good_count',
        'short_good_count',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // イベントが削除される前に実行
        static::deleting(function ($event) {
            // ソフトデリートの場合は、ファイル削除をスキップ
            if (! $event->isForceDeleting()) {
                return;
            }
            // 関連する画像ファイルを削除
            foreach ($event->files as $file) {
                $filePath = 'public/'.$file->path.'/'.$file->name;
                Storage::delete($filePath);
            }

            // 関連するファイルレコードも削除
            $event->files()->delete();
        });
    }

    /** ルートバインディングを解決する*/
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return $this->where('alias', $value)->first();
    }

    /** MeiliSearch 検索可能な配列に変換します。*/
    public function toSearchableArray(): array
    {
        $array = $this->only(
            [
                'id',
                'title',
                'description',
                'good_count',
                'is_forced_hidden',
                'created_user_id',
            ]
        );
        $array['published_at'] = $this->published_at ? Carbon::parse($this->published_at)->getTimestamp() : null;
        $array['start_date'] = $this->published_at ? Carbon::parse($this->start_date)->getTimestamp() : null;
        $array['end_date'] = $this->published_at ? Carbon::parse($this->end_date)->getTimestamp() : null;
        $array['tags'] = $this->tags()->pluck('name')->toArray();
        $array['instance_type_ids'] = $this->instances()->get()->map(function ($instance) {
            return $instance->instance_type_id;
        })->toArray();
        $array['category_ids'] = $this->categories()->pluck('categories.id')->toArray();
        $array['organizers'] = $this->organizers->map(function (EventOrganizer $organizer) {
            return implode(' ', [$organizer->event_organizeble_type, $organizer->event_organizeble->id]);
        })->toArray();
        $array['performers'] = $this->event_time_tables->flatMap(function (EventTimeTable $time_table) {
            return $time_table->performers->map(function (TimeTablePerformer $performer) {
                return implode(' ', [$performer->performable_type, $performer->performable_id]);
            })->toArray();
        })->toArray();

        return $array;
    }

    /**
     * タグを同期する。
     * @param  array<string> $tagNames タグ名の配列
     */
    public function syncTagsByNames(array $tagNames): void
    {
        $tagIds = collect($tagNames)->map(function ($tagName) {
            return Tag::firstOrCreate(['name' => $tagName])->id;
        })->all();
        $this->tags()->sync($tagIds);
    }

    /**
     * カテゴリを同期する。
     * @param  array<string> $categoryNames カテゴリ名の配列
     */
    public function syncCategoriesByNames(array $categoryNames): void
    {
        $categoryIds = collect($categoryNames)->map(function ($categoryName) {
            return Category::firstOrCreate(['name' => $categoryName])->id;
        })->all();
        $this->categories()->sync($categoryIds);
    }

    /**
     * オーガナイザーを同期する
     *
     * @param array $organizersData オーガナイザーのデータ配列
     */
    public function syncOrganizers(array $organizersData)
    {
        // 既存のオーガナイザー関連を一括で削除
        EventOrganizer::where('event_id', $this->id)->delete();

        $now = now(); // 現在の日時を取得
        // バルクインサートを使用してパフォーマンスを向上
        $organizers = array_map(function ($organizerData) use ($now) {
            return [
                'event_id' => $this->id,
                'event_organizeble_type' => $organizerData['type'],
                'event_organizeble_id' => $organizerData['id'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $organizersData);

        EventOrganizer::insert($organizers);
    }

    /** タイムテーブルを同期する。*/
    public function syncTimeTables(array $timeTables): void
    {
        // EventTimeTableのIDを取得
        $timeTableIds = $this->event_time_tables()->pluck('id');
        // 関連するTimeTablePerformerを一括で削除
        TimeTablePerformer::whereIn('event_time_table_id', $timeTableIds)->delete();

        $this->event_time_tables()->delete();
        // 新しいタイムテーブルデータ作成
        foreach ($timeTables as $timeTable) {
            Log::info($timeTable);
            $eventTimeTable = $this->event_time_tables()->create([
                'start_date' => $timeTable['start_date'] ?? null,
                'end_date' => $timeTable['end_date'] ?? null,
                'description' => $timeTable['description'] ?? '',
            ]);
            Log::info($eventTimeTable);

            $performersData = collect($timeTable['performers'])->map(function ($performer) use ($eventTimeTable) {
                return [
                    'event_time_table_id' => $eventTimeTable->id,
                    'performable_id' => $performer['id'],
                    'performable_type' => $performer['type'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();
            TimeTablePerformer::insert($performersData);
        }
    }


    public function syncInstances(array $instances)
    {
        // 既存のインスタンスを削除
        $this->instances()->delete();

        $validatedInstances = collect($instances)->filter(function ($instance) {
            // InstanceType モデルに instance_type_id が存在するか確認
            return \App\Models\InstanceType::find($instance['instance_type_id']) !== null;
        })->all();
        // 新しいインスタンスを一括作成
        $this->instances()->createMany($validatedInstances);
    }

    /** 指定されたユーザーがイベントを操作できるかどうかをチェックします。*/
    public function canUserOperate(User|Authenticatable|null $user): void
    {
        if ($user === null) {
            throw new CannotOperateEventException('操作権限がありません。');
        }
        if($this->created_user_id !== $user->getAuthIdentifier()) {
            throw new CannotOperateEventException('操作権限がありません');
        }
    }

    /**
     * 指定されたユーザーがこのイベントを表示可能かどうかを判定します。
     *
     * 条件:
     * - イベントが非公開の場合、イベントの作成者であれば表示可能
     * - イベントが強制的に非公開にされているか
     * - イベントが公開されている（published_atが過去の日時）
     */
    public function canUserShow(User|Authenticatable|null $user): bool
    {
        // イベントの作成者であれば表示可能
        if($this->created_user_id === $user?->getAuthIdentifier()) {
            \Log::info('created_user_id');
            return true;
        }

        // イベントが強制的に非公開にされているか
        if($this->is_forced_hidden) {
            throw new EventNotPublishedException('イベントは運営者によって強制的に非公開にされています。');
        }

        // イベントが公開されているか
        if (isset($this->published_at) && $this->published_at->isPast()) {
            return true;
        }
        throw new EventNotPublishedException('イベントはまだ公開されていません。');
    }

    /** イベント管理者確認可能なイベントのステータス*/
    public static function canManagerSearchStatus(): array
    {
        return [
            EventStatus::DRAFT,
            EventStatus::UPCOMING,
            EventStatus::ONGOING,
            EventStatus::CLOSED,
            EventStatus::FORCED_HIDDEN,
        ];
    }


    /** 一般公開可能なイベントのステータス*/
    public static function canGeneralSearchStatus(): array
    {
        return [
            EventStatus::UPCOMING,
            EventStatus::ONGOING,
            EventStatus::CLOSED,
        ];
    }

    /**
     *  一般公開可能なイベントのステータス
     * - EventStatus::UPCOMING
     * - EventStatus::ONGOING
     * - EventStatus::CLOSED
     */
    public function scopeGeneralPublished($query): Builder
    {
        return $query->where('is_forced_hidden', false)
            ->where('published_at', '<=', now());
    }

    /** 一般公開しているClosedイベントのスコープ。*/
    public function scopeClosedPublished($query): Builder
    {
        return $query->where('is_forced_hidden', false)
            ->where('published_at', '>', now())
            ->where('end_date', '<', now());
    }

    /** 一般公開しているOngoingイベントのスコープ。*/
    public function scopeOngoingPublished($query): Builder
    {
        $now = now();
        return $query->where('is_forced_hidden', false)
            ->where('published_at', '<=', $now)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now);
    }

    /** 一般公開しているUpcomingイベントのスコープ。*/
    public function scopeUpcomingPublished($query): Builder
    {
        return $query->where('is_forced_hidden', false)
            ->where('published_at', '<=', now())
            ->where('start_date', '>', now());
    }

    /** イベントがDraftのスコープ。*/
    public function scopeDraft($query): Builder
    {
        return $query->where('published_at', null);
    }

    /** イベントが公開されているスコープ。*/
    public function scopePublished($query): Builder
    {
        //TODO:現在は予約公開は入れてないので nullでなければ公開状態
        return $query->whereNotNull('published_at');
    }

    /** イベントのオーナーが閲覧することができるイベントのスコープ。*/
    public function scopeCreatedUser($query, User|Authenticatable|null $user): Builder
    {
        return $query->where('created_user_id', $user->getAuthIdentifier());
    }

    public function getStatusAttribute(): EventStatus
    {
        $now = now();

        // イベントが強制的に非公開にされている場合
        if ($this->is_forced_hidden) {
            return EventStatus::FORCED_HIDDEN;
        }

        // イベントが公開準備中（ドラフト）
        if (is_null($this->published_at)) {
            return EventStatus::DRAFT;
        }

        // イベントがまだ公開されていない場合
        if ($this->published_at > $now) {
            return EventStatus::UNPUBLISHED;
        }

        // イベントの開始前
        if ($this->start_date > $now) {
            return EventStatus::UPCOMING;
        }

        // イベントが進行中
        if ($this->start_date <= $now && $this->end_date >= $now) {
            return EventStatus::ONGOING;
        }

        // イベントが終了した
        if ($this->end_date < $now) {
            return EventStatus::CLOSED;
        }

        return EventStatus::DRAFT;
    }

    /** イベントを複製する。*/
    public function duplicateEvent(): Event
    {
        $duplicatedEvent = $this->replicate();
        $duplicatedEvent->title = $this->title . ' - copy';
        $duplicatedEvent->published_at = null;
        $duplicatedEvent->alias = Str::lower(Str::ulid());
        $duplicatedEvent->save();

        $duplicatedEvent->instances()->createMany($this->instances->toArray());
        $duplicatedEvent->categories()->attach($this->categories->pluck('id'));
        $duplicatedEvent->tags()->attach($this->tags->pluck('id'));
        $duplicatedEvent->organizers()->createMany($this->organizers->toArray());
        $this->event_time_tables->each(function ($eventTimeTable) use ($duplicatedEvent) {
            $duplicatedEventTimeTable = $duplicatedEvent->event_time_tables()->create($eventTimeTable->toArray());
            $duplicatedEventTimeTable->performers()->createMany($eventTimeTable->performers->toArray());
        });
        return $duplicatedEvent;
    }


}
