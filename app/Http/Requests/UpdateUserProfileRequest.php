<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
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
            'bio' => $this->input('bio'),
            'tags' => $this->input('tags'),
            'links' => $this->input('links'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bio' => [
                'nullable',
                'string',
                'max:300',
            ],
            'tags' => [
                'nullable',
                'array',
                'max:5',
                'distinct',
            ],
            'links' => [
                'nullable',
                'array',
                'max:5',
                'distinct',
            ],
            'links.*.link' => 'url',
            'links.*.label' => 'string',
        ];
    }
    public function messages()
    {
        return [
            'links.*.link.required' => 'リンクを入力してください。',
            'links.*.link.url' => 'リンクは有効なURL形式で指定してください。',
            'links.*.label.required' => 'ラベルを入力してください。',
            'links.*.label.string' => 'ラベルには文字列を指定してください。',
        ];
    }
}
