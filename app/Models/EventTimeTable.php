<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventTimeTable extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'performance_time',
    ];

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'start_time',
        'end_time',
        'description',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * 出演時間
     */
    public function getPerformanceTimeAttribute(): string
    {
        return $this->start_time.' ~ '.$this->end_time;
    }

    /**
     * 開始時間
     */
    public function getStartTimeAttribute($value): string
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * 終了時間
     */
    public function getEndTimeAttribute($value): string
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * イベント
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * 出演者
     */
    public function performers(): HasMany
    {
        return $this->hasMany(TimeTablePerformers::class);
    }
}
