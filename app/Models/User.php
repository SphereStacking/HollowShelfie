<?php

namespace App\Models;

use App\Models\SocialAccount;
use Laravel\Jetstream\HasTeams;
use App\Traits\UserProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use UserProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

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
        'profile_photo_url', 'links'
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

    //外部認証アカウントリレーション
    public function social_accounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    //
    public function like_events()
    {
        return $this->belongsToMany(Event::class, 'event_user_like');
    }

    // GroupModel が複数のイベントを主催している場合
    public function good_events()
    {
        return $this->belongsToMany(Event::class, 'event_user_good');
    }

    /**
     * このUserがオーガナイザーしているイベントを取得
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

    //フォロー機能 Userがフォローしている人
    public function follows()
    {
        return $this->morphToMany(User::class, 'followable', 'follows', 'user_id', 'followable_id');
    }

    //フォロー機能 Userをfollowしている人
    public function followers()
    {
        return $this->morphToMany(User::class, 'followable', 'follows')->withTimestamps();
    }
    // ユーザーのフォロワー数を取得する
    public function followersCount()
    {
        return $this->followers()->count();
    }

    // このユーザーがフォローしている人数を取得する
    public function followingsCount()
    {
        return $this->followings()->count();
    }

    // 認証してるユーザーがフォローしているがどうか
    public function isFollowed()
    {
        return $this->followers()->where('user_id', auth()->id())->exists();
    }
}
