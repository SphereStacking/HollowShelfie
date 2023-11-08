<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;
use App\Traits\TeamLogo;

class Team extends JetstreamTeam
{
    use HasFactory;
    use TeamLogo;
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
        'team_logo_url', 'links'
    ];

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
     * このTeamのイベントオーガナイザー取得
     */
    public function event_organizers()
    {
        return $this->morphMany(EventOrganizer::class, 'event_organizeble');
    }

    //リンク
    public function links()
    {
        return $this->morphMany(Link::class, 'linkable');
    }

    //フォロー機能 Teamをfollowしている人
    public function followers()
    {
        return $this->morphToMany(User::class, 'followable', 'follows')->withTimestamps();
    }
    // チームのフォロワー数を取得する
    public function followersCount()
    {
        return $this->followers()->count();
    }
}
