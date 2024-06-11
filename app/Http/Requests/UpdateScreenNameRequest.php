<?php

namespace App\Http\Requests;

use App\Rules\ReservedWord;
use App\Rules\CaseInsensitiveUnique;
use Illuminate\Foundation\Http\FormRequest;

class UpdateScreenNameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * イベントストア用の属性を取得します。
     */
    public function getAttributes(): array
    {
        return [
            'screen_name' => $this->input('screen_name'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // TODO: trait HasScreenNameableのバリエーションしているので変更時気を付けて
        return [
            'screen_name' => [
                'required',
                'alpha_dash',
                'min:3',
                'max:14',
                'unique:screen_names,screen_name',
                new ReservedWord(),
                new CaseInsensitiveUnique('screen_names', 'screen_name'),
            ],
        ];
    }
}
