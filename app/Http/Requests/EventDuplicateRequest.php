<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventDuplicateRequest extends FormRequest
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
            'title' => $this->input('title') ?? '',
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
            'title' => 'required|string',
        ];
    }
}
