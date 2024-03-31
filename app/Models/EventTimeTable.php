<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $fillable = [
        'start_time',
        'end_time',
        'description',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function getPerformanceTimeAttribute()
    {
        return $this->start_time.' ~ '.$this->end_time;
    }

    public function getStartTimeAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function getEndTimeAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
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
