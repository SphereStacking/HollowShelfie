<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Tag extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name'];

    public function taggables()
    {
        return $this->hasMany(Taggable::class);
    }

    public function events()
    {
        return $this->morphedByMany(Event::class, 'taggable');
    }

    public function users()
    {
        return $this->morphedByMany(User::class, 'taggable');
    }

    /**
     * MeiliSearch 検索可能な配列に変換します。
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->only(
            [
                'id',
                'name',
            ]
        );

        //TODO:こちらはN+1が出るかもしれず。パフォーマンスに影響がある可能性があり。
        $array['total_count'] = $this->taggables()->count();
        $array['event_count'] = $this->events()->count();
        $array['user_count'] = $this->users()->count();

        return $array;
    }
}
