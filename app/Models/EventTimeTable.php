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
        'duration',
    ];

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'description',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function getDurationAttribute(): ?int
    {
        if ($this->start_date === null || $this->end_date === null) {
            return null;
        }

        return $this->end_date->diffInMinutes($this->start_date);
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
