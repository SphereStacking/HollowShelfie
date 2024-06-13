<?php

namespace App\Models;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScreenName extends Model
{
    use HasFactory;

    protected $fillable = ['screen_name'];

    public function screenNameable()
    {
        return $this->morphTo();
    }

    public static function findScreenNameable($screen_name)
    {
        return ScreenName::where('screen_name', $screen_name)->firstOrFail();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'screen_nameable_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'screen_nameable_id');
    }

    public function scopeSearchByScreenNameOrMorphName(Builder $query, $searchTerm)
    {
        return $query->where('screen_name', 'like', "%{$searchTerm}%")
            ->orWhereHasMorph('screenNameable', [User::class, Team::class], function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%");
            })
            ->with('screenNameable'); // リレーションを事前にロード
    }
}
