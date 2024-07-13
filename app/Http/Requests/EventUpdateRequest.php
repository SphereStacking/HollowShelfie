<?php

namespace App\Http\Requests;

use App\Enums\EventStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
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
            'description' => $this->input('description') ?? '',
            'start_date' => $this->input('start_date') ?? '',
            'end_date' => $this->input('end_date') ?? '',
            'organizers' => $this->input('organizers') ?? [],
            'performers' => $this->input('performers') ?? [],
            'time_tables' => $this->input('time_tables') ?? [],
            'instances' => $this->input('instances') ?? [],
            'published_at' => $this->input('published_at') ?? null,
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'description' => '説明',
            'images.*' => '画像',
            'categories' => 'カテゴリー',
            'instances' => 'インスタンス',
            'instances.*.instance_type_id' => 'プラットフォーム',
            'instances.*.display_name' => '表示ラベル',
            'published_at' => '公開日',
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
        if ($this->input('published_at') == null) {
            return [];
        }

        //ドラフト以外
        return [
            'title' => 'required|string',
            'published_at' => 'nullable|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'required|string',
            'categories' => 'required|array|min:1|max:4',
            'tags' => 'array|max:8',
            'instances' => 'required|array|max:1',
            'instances.*.instance_type_id' => 'required|exists:instance_types,id',
            'instances.*.display_name' => 'required|string',
        ];
    }

}
