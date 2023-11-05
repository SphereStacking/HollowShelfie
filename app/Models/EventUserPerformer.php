<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EventUserPerformer extends Pivot
{
    // Pivotモデルで使用するテーブル名を指定
    protected $table = 'event_user_performer';

    // モデルの配列やJSON出力に含めるアクセサ属性を指定
    protected $appends = ['performance_time'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    //
    public function getPerformanceTimeAttribute()
    {
        // start_time と end_time が設定されていることを確認
        if ($this->start_time && $this->end_time) {
            // DateTime を使用して時間をフォーマット
            $startTime = $this->start_time->format('H:i');
            $endTime = $this->end_time->format('H:i');
            // フォーマットした文字列を結合して返す
            return "{$startTime} ~ {$endTime}";
        }
        // start_time または end_time が設定されていない場合は、空文字列を返す
        return '';
    }
}
