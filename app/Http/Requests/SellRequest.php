<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
            'parent_category' => ['required'],
            'child_category' => ['required'],
            'condition' => ['required'],
            'name' => ['required', 'string', 'max:191'],
            'description' => ['required'],
            'price' => ['required'],
            'item_image' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'parent_category.required' => 'カテゴリーを選択してください',
            'child_category.required' => 'カテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'name.required' => '商品名を入力してください',
            'name.max' => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'price.required' => '販売価格を入力してください',
            'item_image.required' => '商品画像のアップロードは必須です',
        ];
    }
}
