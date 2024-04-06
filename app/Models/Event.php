<?php

namespace App\Models;

use App\Enums\EventStatus;
use App\Models\Traits\EventGetters;
use App\Models\Traits\EventRelations;
use App\Models\Traits\EventScopes;
use App\Models\Traits\EventSetters;
use App\Traits\HasFileable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

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
     * @var array 可変の属性
     */
    protected $fillable = ['title', 'description', 'status '];

    /**
     * @var array
     */
    protected $appends = [
        'created_user', 'status_label', 'tags', 'category_names',
        'is_bookmark', 'is_good', 'category_name', 'instances', 'good_count',
        'short_good_count', 'event_timeline_status',
    ];

    protected $casts = [
        'published_at' => 'datetime',
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

    /**
     * MeiliSearch 検索可能な配列に変換します。
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->only(
            [
                'id',
                'title',
                'description',
                'status',
                'created_user',
                'status_label',
                'good_count',
            ]
        );
        $array['published_at'] = $this->published_at ? Carbon::parse($this->published_at)->getTimestamp() : null;
        $array['start_date'] = $this->published_at ? Carbon::parse($this->start_date)->getTimestamp() : null;
        $array['end_date'] = $this->published_at ? Carbon::parse($this->end_date)->getTimestamp() : null;
        $array['tags'] = $this->tags()->get()->pluck('name')->toArray();
        $array['instances'] = $this->instances()->get()->map(function ($instance) {
            return [
                'location' => $instance->location,
                'instance_type_name' => $instance->instance_type_name,
            ];
        })->toArray();
        $array['categories'] = $this->categories()->get()->pluck('name')->toArray();
        $array['organizers'] = $this->organizers->pluck('event_organizeble.name')->toArray();
        $array['performers'] = $this->event_time_tables->flatMap(function ($time_table) {
            return $time_table->performers->pluck('performable.name');
        });

        return $array;
    }

    /**
     * タグを同期する。
     *
     * @param  array  $tagNames タグ名の配列
     * @return void
     */
    public function syncTagsByNames(array $tagNames)
    {
        $existingTags = Tag::whereIn('name', $tagNames)->get()->keyBy('name');
        $tagIds = collect($tagNames)->map(function ($tagName) use ($existingTags) {
            return $existingTags->has($tagName) ?
                   $existingTags[$tagName]->id :
                   Tag::create(['name' => $tagName])->id;
        })->all();
        $this->tags()->sync($tagIds);
    }

    /**
     * カテゴリを同期する。
     *
     * @param  array  $categoryIds カテゴリIDの配列
     * @return void
     */
    public function syncCategoriesByNames(array $categoryNames)
    {
        $existingCategories = Category::whereIn('name', $categoryNames)->get()->keyBy('name');
        $categoryIds = collect($categoryNames)->map(function ($categoryName) use ($existingCategories) {
            return $existingCategories->has($categoryName) ?
                   $existingCategories[$categoryName]->id :
                   Category::create(['name' => $categoryName])->id;
        })->all();
        $this->categories()->sync($categoryIds);
    }

    /**
     * オーガナイザーを同期する
     *
     * @param  array  $organizersData オーガナイザーのデータ配列
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

    /**
     * タイムテーブルを同期する。
     *
     * @param  array  $categoryIds カテゴリIDの配列
     * @return void
     */
    public function syncTimeTables(array $timeTables)
    {

        // EventTimeTableのIDを取得
        $timeTableIds = $this->event_time_tables()->pluck('id');
        // 関連するTimeTablePerformersを一括で削除
        TimeTablePerformers::whereIn('event_time_table_id', $timeTableIds)->delete();

        $this->event_time_tables()->delete();
        Log::debug('timeTables');
        // 新しいタイムテーブルデータ作成
        foreach ($timeTables as $timeTable) {
            Log::debug($timeTable);

            $eventTimeTable = $this->event_time_tables()->create([
                'start_time' => $timeTable['times'][0] ?? null,
                'end_time' => $timeTable['times'][1] ?? null,
                'description' => $timeTable['description'] ?? '',
            ]);

            $performersData = collect($timeTable['performers'])->map(function ($performer) use ($eventTimeTable) {
                return [
                    'event_time_table_id' => $eventTimeTable->id,
                    'performable_id' => $performer['id'],
                    'performable_type' => $performer['type'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();
            TimeTablePerformers::insert($performersData);
        }
    }

    public function updateEventStatus(EventStatus $newStatus)
    {

        switch ($newStatus) {
            case EventStatus::DRAFT:
                $this->status = $newStatus->value;
                $this->published_at = null;
                break;
            case EventStatus::CLOSED:
            case EventStatus::UPCOMING:
            case EventStatus::CANCELED:
                $this->status = $newStatus->value;
                if ($this->published_at === null) {
                    $this->published_at = now();
                }
                break;

            default:
                throw new \Exception('Invalid status');
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

    /**
     * 指定されたユーザーがイベントを操作できるかどうかをチェックします。
     *
     * @param  \App\Models\User  $user チェックするユーザー
     * @return bool ユーザーが操作できる場合はtrue、そうでない場合はfalse
     */
    public function canUserOperate(User $user): bool
    {
        return $this->event_create_user_id === $user->id;
    }
}
