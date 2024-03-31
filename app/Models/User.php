<?php

namespace App\Models;

use App\Models\Traits\UserRelations;
use App\Traits\HasCustomIdentifiable;
use App\Traits\HasFollowable;
use App\Traits\UserProfilePhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasCustomIdentifiable;
    use HasFactory;
    use HasFollowable;
    use HasTeams;
    use Notifiable;
    use Searchable;
    use TwoFactorAuthenticatable;
    use UserProfilePhoto;
    use UserRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url', 'links', 'profile_url', 'screen_name',
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

    public function getProfileUrlAttribute()
    {
        return route('user.profile.show', $this->customIdentifiable->alias_name);
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
