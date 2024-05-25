<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTablePerformers extends Model
{
    use HasFactory;

    protected $fillable = [
        'performable_type',
        'performable_id',
    ];

    public function timeTable()
    {
        return $this->belongsTo(EventTimeTable::class);
    }

    public function performable()
    {
        return $this->morphTo();
    }
}
