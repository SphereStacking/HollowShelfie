<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventTimeTable extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'performance_time'
    ];



    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function getPerformanceTimeAttribute()
    {
        return $this->start_date->format('H:i') . ' ~ ' . $this->end_date->format('H:i');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function performers()
    {
        return $this->hasMany(TimeTablePerformers::class);
    }
}
