<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTablePerformers extends Model
{
    use HasFactory;

    public function timeTable()
    {
        return $this->belongsTo(EventTimeTable::class);
    }

    public function performable()
    {
        return $this->morphTo();
    }
}
