<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * @var array<int, string>
     */
    protected $fillable = ['name'];

    public function taggables(): HasMany
    {
        return $this->hasMany(Taggable::class);
    }

    public function events(): MorphToMany
    {
        return $this->morphedByMany(Event::class, 'taggable');
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'taggable');
    }

    /**
     * MeiliSearch 検索可能な配列に変換します。
     */
    public function toSearchableArray(): array
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
