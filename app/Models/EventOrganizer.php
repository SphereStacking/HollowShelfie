<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventOrganizer extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = ['event_id', 'event_organizeble_type', 'event_organizeble_id'];


    /**
     * イベント
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * organizer
     */
    public function event_organizeble(): MorphTo
    {
        return $this->morphTo();
    }
}
