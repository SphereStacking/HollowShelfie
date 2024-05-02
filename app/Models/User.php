<?php

namespace App\Models;

use Filament\Panel;
use App\Traits\HasFollowable;
use Laravel\Scout\Searchable;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Traits\UserRelations;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use JoelButcher\Socialstream\HasConnectedAccounts;
use JoelButcher\Socialstream\SetsProfilePhotoFromUrl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser
{
    use HasApiTokens;
    use HasConnectedAccounts;
    use HasFactory;
    use HasFollowable;
    use HasProfilePhoto {
        HasProfilePhoto::profilePhotoUrl as getPhotoUrl;
    }
    use HasTeams;
    use Notifiable;
    use Searchable;
    use SetsProfilePhotoFromUrl;
    use TwoFactorAuthenticatable;
    use UserRelations;

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
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
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
     * The attributes that should be cast to native types.
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
        'profile_photo_url',
        'links',
        'profile_url',
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

    /**
     * Get the URL to the user's profile photo.
     */
    public function profilePhotoUrl(): Attribute
    {
        return filter_var($this->profile_photo_path, FILTER_VALIDATE_URL)
            ? Attribute::get(fn () => $this->profile_photo_path)
            : $this->getPhotoUrl();
    }

    /**
     * 関連付けられているlink
     */
    public function getLinksAttribute(): array
    {
        return $this->links()->get()->toArray();
    }

    /**
     * profileページへのURL
     */
    public function getProfileUrlAttribute(): string
    {
        return route('user.profile.show', $this->screen_name);
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
                'bio',
            ]
        );
        $array['tags'] = $this->tags()->pluck('name')->toArray();

        return $array;
    }

    public function getRouteBindingRelations(): array
    {
        return ['links', 'tags'];
    }


    /**
     * Filament のアクセスできるか
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->email, config('app.admin.emails')) && $this->hasVerifiedEmail();
    }
}
