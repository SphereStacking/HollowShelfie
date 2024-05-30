<?php

namespace App\Models;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScreenName extends Model
{
    use HasFactory;

    protected $fillable = ['screen_name'];

    public function screen_nameable()
    {
        return $this->morphTo();
    }

    public static function findScreenNameable($screen_name)
    {
        return ScreenName::where('screen_name', $screen_name)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'screen_nameable_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'screen_nameable_id');
    }
}
