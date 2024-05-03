<?php

namespace App\Models;

use App\Models\Traits\TeamRelations;
use App\Traits\HasFollowable;
use App\Traits\TeamLogo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;
use Laravel\Scout\Searchable;

class Team extends JetstreamTeam
{
    use HasFactory;
    use HasFollowable;
    use Searchable;
    use TeamLogo;
    use TeamRelations;

    /**
     * ルートキー名を取得する
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'screen_name';
    }

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
        'team_logo_url', 'links', 'profile_url',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            do {
                $randomScreenName = bin2hex(random_bytes(7));
            } while (User::where('screen_name', $randomScreenName)->exists());
            $user->screen_name = $randomScreenName;
        });
    }



    public function getProfileUrlAttribute()
    {
        return route('team.profile.show', $this->screen_name);
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
        $array['tags'] = $this->tags()->pluck('name')->toArray();

        return $array;
    }
}
