<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        $rules = [];

        // ユーザー名のルール（入力がある場合のみ適用）
        if (!empty($this->input('name'))) {
            $rules['name'] = ['max:191'];
        }
        // 郵便番号のルール（入力がある場合のみ適用）
        if (!empty($this->input('postcode'))) {
            $rules['postcode'] = ['regex:/^[0-9A-Za-z-]{8}$/'];
        }
        // 住所のルール（入力がある場合のみ適用）
        if (!empty($this->input('address'))) {
            $rules['address'] = ['max:255'];
        }
        // 建物名のルール（入力がある場合のみ適用）
        if (!empty($this->input('building_name'))) {
            $rules['building_name'] = ['max:255'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.max' => 'ユーザー名は191文字以内で入力してください',
            'postcode.regex' => 'ハイフンを入れた8文字の郵便番号を入力してください',
            'address.max' => '住所は255文字以内で入力してください',
            'building_name.max' => '建物名は255文字以内で入力してください',
        ];
    }
}
