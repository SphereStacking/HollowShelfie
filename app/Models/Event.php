<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\EventStatus;
use Laravel\Scout\Searchable;
use App\Models\Traits\EventScopes;
use App\Models\Traits\EventGetters;
use App\Models\Traits\EventSetters;
use Illuminate\Support\Facades\Log;
use App\Models\Traits\EventRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    use Searchable;

    use EventGetters;
    use EventSetters;
    use EventScopes;
    use EventRelations;

    /**
     * @var array 可変の属性
     */
    protected $fillable = ['title', 'description'];

    /**
     * @var array 可変の属性
     */
    protected $appends = [
        'created_user', 'status_label', 'tags',
        'is_bookmark', 'is_good', 'category_name', 'instances', 'good_count',
        'short_good_count', 'event_timeline_status'
    ];


    /**
     * モデルの"booting"メソッド
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if (
                !in_array(EventStatus::getStatus($model->status), [
                    EventStatus::DRAFT, EventStatus::DELETED
                ]) &&
                $model->published_at == null
            ) {
                $model->published_at = now();
            }
        });
    }




    public function searchable(): bool
    {
        return $this->published_at != null;
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
                'creted_user',
                'status_label',
                'good_count',
            ]
        );
        $array['published_at'] = $this->published_at ? Carbon::parse($this->published_at)->getTimestamp() : null;
        $array['start_date'] =  $this->published_at ? Carbon::parse($this->start_date)->getTimestamp() : null;
        $array['end_date'] =  $this->published_at ? Carbon::parse($this->end_date)->getTimestamp() : null;
        $array['tags'] = $this->tags()->get()->pluck('name')->toArray();
        $array['instances'] = $this->instances()->get()->map(function ($instance) {
            return [
                'location' => $instance->location,
                'instance_type_name' => $instance->instance_type_name,
            ];
        })->toArray();
        $array['categories'] = $this->categories()->get()->pluck('name')->toArray();
        // $array['performers'] = $this->performers()->get()->pluck('name')->toArray();
        $array['organizers'] = $this->organizers->pluck('event_organizeble.name')->toArray();

        $array['performers'] = $this->event_time_tables->flatMap(function ($time_table) {
            return $time_table->performers->pluck('performable.name');
        });
        return $array;
    }

    public static function getSearchFilterAttributes(): array
    {
        return [
            'id',
            // 'title',
            // 'start_date',
            // 'end_date',
            // 'description',
            // 'status',
            // 'published_at',
            // 'creted_user',
            // 'status_label',
            // 'tags.name',
            // 'instances.*.location',
            // 'instances.*.instance_type_name',
            // 'categories.*',
        ];
    }
}
