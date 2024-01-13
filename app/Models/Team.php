<?php

namespace App\Models;

use App\Traits\TeamLogo;
use App\Traits\HasFollowable;
use Laravel\Scout\Searchable;
use App\Models\Traits\TeamRelations;
use App\Traits\HasCustomIdentifiable;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends JetstreamTeam
{
    use TeamRelations;

    use HasFactory;
    use TeamLogo;
    use Searchable;
    use HasCustomIdentifiable;
    use HasFollowable;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'personal_team' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'personal_team',
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'team_logo_url', 'links', 'profile_url','screen_name'
    ];

    public function getProfileUrlAttribute()
    {
        return route('team.profile.show', $this->customIdentifiable->alias_name);
    }

    /**
     * 関連付けられているlink
     *
     * @return string|null
     */
    public function getLinksAttribute()
    {
        return $this->links()->get();
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
                'bio',
            ]
        );
        $array['tags'] = $this->tags()->get()->pluck('name')->toArray();
        return $array;
    }
}
