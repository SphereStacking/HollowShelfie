<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            't' => ['nullable', 'string'],
            'q.*.include' => ['required', 'in:and,or,not'],
            'q.*.type' => ['required', 'in:category,tag,user,status,date'],
            'paginate' => ['nullable', 'integer', 'max:100'],

        ];
    }
}
