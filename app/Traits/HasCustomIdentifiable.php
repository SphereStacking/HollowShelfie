<?php

namespace App\Traits;

use App\Models\CustomIdentifiable;
use App\Rules\ReservedWord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * カスタム識別子を持つモデルのためのトレイト
 */
trait HasCustomIdentifiable
{
    // PostgreSQLの整合性制約違反エラーコード
    const INTEGRITY_CONSTRAINT_VIOLATION = 23000;

    /**
     * ブート時にカスタム識別子を作成する
     */
    protected static function booted()
    {
        static::created(function ($model) {
            $model->createCustomIdentifiable();
        });
    }

    public function getScreenNameAttribute()
    {
        return $this->customIdentifiable->screen_name;
    }

    /**
     * カスタムID属性を取得する
     *
     * @return CustomIdentifiable|null
     */
    public function getCustomIdAttribute()
    {
        return $this->customIdentifiable()->first();
    }

    /**
     * ルートキー名を取得する
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'customIdentifiable.screen_name';
    }

    /**
     * ルートバインディングを解決する
     */
    public function resolveRouteBinding(mixed $value, mixed $field = null): ?Model
    {
        return $this->whereHas('customIdentifiable', function ($query) use ($value) {
            $query->where('screen_name', $value);
        })->first() ?? abort(404, 'Not found');
    }

    /**
     * カスタム識別子リレーションを取得する
     */
    public function customIdentifiable(): MorphOne
    {
        return $this->morphOne(CustomIdentifiable::class, 'identifiable');
    }

    /**
     * カスタム識別子を更新する
     *
     * @param string $newAliasName
     *
     * @throws ValidationException
     */
    public function updateCustomIdentifiable($newAliasName)
    {
        $validator = Validator::make(['screen_name' => $newAliasName], $this->getValidationRules($newAliasName));

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->customIdentifiable()->update(['screen_name' => $newAliasName]);
    }

    /**
     * カスタム識別子を更新できるかどうかを判断する
     *
     * @param  string $newAliasName
     * @return bool
     */
    public function canUpdateCustomIdentifiable($newAliasName)
    {
        $validator = Validator::make(['screen_name' => $newAliasName], $this->getValidationRules($newAliasName));

        return ! $validator->fails();
    }


    /**
     * カスタム識別子を作成する
     */
    protected function createCustomIdentifiable()
    {
        retry(
            config('retry.custom_identifiable.attempts', 20),
            function () {
                $screen_name = bin2hex(random_bytes(config('retry.custom_identifiable.random_bytes', 8)));
                $this->customIdentifiable()->create(['screen_name' => $screen_name]);
            },
            config('retry.custom_identifiable.sleep_milliseconds', 100),
            function ($e) {
                // ユニークでなかった時
                return $e->getCode() == self::INTEGRITY_CONSTRAINT_VIOLATION;
            }
        );
    }

    /**
     * バリデーション
     *
     * @param  string $newAliasName
     * @return array
     */
    public function updateValidate($newAliasName)
    {
        $validator = Validator::make(['screen_name' => $newAliasName], [
            'alpha_dash',
            'min:3',
            'max:14',
            new ReservedWord(),
            Rule::unique('custom_identifiables')->where(function ($query) use ($newAliasName) {
                return $query->where('screen_name', $newAliasName)
                    ->where('identifiable_type', get_class($this));
            }),
        ]);
        \Log::info('updateValidate', ['newAliasName' => $newAliasName]);

        if ($validator->fails()) {
            \Log::info('Validation failed');
            return $validator->errors(); // バリデーションエラーを返す
        }
        return $validator->validate();
    }
}
