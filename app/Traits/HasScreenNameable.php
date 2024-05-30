<?php
namespace App\Traits;

use App\Rules\ReservedWord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Models\ScreenName;
use Illuminate\Database\Eloquent\Builder;

trait HasScreenNameable
{
    /**
     * ブート時にカスタム識別子を作成する
     */
    protected static function booted()
    {
        static::addGlobalScope('withScreenName', function (Builder $builder) {
            $builder->with('screenName');
        });
        static::created(function ($model) {
            $randomScreenName = null;
            do {
                $randomScreenName = bin2hex(random_bytes(7));
            } while ($model->screenName()->where('screen_name', $randomScreenName)->exists());
            $model->screenName()->create(['screen_name' => $randomScreenName]);
        });
        parent::booted();
    }

    /** ルートキー名を取得する */
    public function getRouteKeyName(): string
    {
        return 'screenName.screen_name';
    }

    /** ルートバインディングを解決する */
    public function resolveRouteBinding(mixed $value, mixed $field = null): ?Model
    {
        return $this->whereHas('screen_names', function ($query) use ($value) {
            $query->where('screen_name', $value);
        })->first() ?? abort(404);
    }

    /** ScreenNameモデルとのリレーションを取得する */
    public function screenName(): MorphOne
    {
        return $this->morphOne(ScreenName::class, 'screen_nameable');
    }

    /** スクリーンネームを取得する */
    public function getScreenNameAttribute()
    {
        return $this->screenName()->first() ? $this->screenName()->first()->screen_name : null;
    }

    /** profileページへのURL */
    public function getProfileUrlAttribute(): string
    {
        return route('profile.show', ['screen_name' => $this->screen_name]);
    }

    /**
     * カスタム識別子を更新する
     *
     * @throws ValidationException
     */
    public function changeScreenName(string $newScreenName): void
    {
        $validator = Validator::make(['screen_name' => $newScreenName], [
            'alpha_dash',
            'min:3',
            'max:14',
            'unique:screen_names,screen_name',
            new ReservedWord(),
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->screenName()->update(['screen_name' => $newScreenName]);
    }

}
