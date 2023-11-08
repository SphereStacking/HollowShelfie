<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventTimeTable extends Model
{
    use HasFactory;

    // モデルの配列やJSON出力に含めるアクセサ属性を指定
    // protected $appends = ['performance_time'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function performers()
    {
        return $this->hasMany(TimeTablePerformers::class);
    }
}
