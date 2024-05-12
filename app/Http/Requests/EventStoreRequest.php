<?php

namespace App\Http\Requests;

use App\Enums\EventStatus;
use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'categories' => $this->input('categories') ?? [],
            'tags' => $this->input('tags') ?? [],
            'description' => $this->input('description') ?? [],
            'dates' => $this->input('dates') ?? [],
            'organizers' => $this->input('organizers') ?? [],
            'performers' => $this->input('performers') ?? [],
            'time_tables' => $this->input('time_tables') ?? [],
            'images' => $this->file('images') ?? [],
            'instances' => $this->input('instances') ?? [],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //ドラフトのとき
        if ($this->input('publish_at') === null) {
            return [
                'images.*' => 'file|max:30720', //30MB
            ];
        }

        //ドラフト以外
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'images.*' => 'file|max:30720', //30MB
            'categories' => 'required|array|min:1',
            'instances' => 'required|array|max:1', //現状は
            'instances.*.access_url' => 'required|string',
            'instances.*.display_name' => 'required|string',
        ];
    }
}
