<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventOrganizer extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'event_organizeble_type', 'event_organizeble_id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function event_organizeble()
    {
        return $this->morphTo();
    }
}
