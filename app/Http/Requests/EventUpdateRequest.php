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
            'dates' => $this->input('dates') ?? [],
            'organizers' => $this->input('organizers') ?? [],
            'performers' => $this->input('performers') ?? [],
            'time_tables' => $this->input('time_tables') ?? [],
            'status' => EventStatus::from($this->input('status', EventStatus::DRAFT->value)),
            'instances' => $this->input('instances') ?? [],
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
            'instances.*.instance_type_id' => 'インスタンスのタイプ',
            'instances.*.display_name' => '表示ラベル',
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
        if ($this->input('status') == EventStatus::DRAFT->value) {
            return [];
        }

        //ドラフト以外
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'categories' => 'required|array|min:1',
            'instances' => 'required|array|max:1',
            'instances.*.instance_type_id' => 'required|exists:instance_types,id',
            'instances.*.display_name' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        $errorsPerRow = [];
        foreach ($validator->errors()->getMessages() as $field => $messages) {
            // 'instances.*'にマッチするフィールド名の場合、エラーを集約する
            if (mb_strpos($field, 'instances.') === 0) {
                $errorsPerRow['instances'][] = $messages[0];
            } else {
                $errorsPerRow[$field] = $messages;
            }
        }

        // 'instances'に関連するエラーメッセージを一つにまとめる
        if (isset($errorsPerRow['instances'])) {
            $validator->errors()->add('instances', implode(' ', $errorsPerRow['instances']));
        }

        parent::failedValidation($validator);
    }
}
