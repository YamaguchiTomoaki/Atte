<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OriginalRegisterRequest extends FormRequest
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
            'name' => 'required | string | max:255',
            'email' => 'required | unique:users,email, | string | max:255',
            'password' => 'required | confirmed | string | max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.string' => '名前を文字列で入力してください',
            'name.max' => '名前を255文字以内で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.unique' => 'このメールアドレスは既に使用されています',
            'email.string' => 'メールアドレスを文字列で入力してください',
            'email.max' => 'メールアドレスを255文字以内で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.confirmed' => 'パスワードと確認用パスワードが一致しません',
            'password.string' => 'パスワードを文字列で入力してください',
            'password.max' => 'パスワードを255文字以内で入力してください',
        ];
    }
}
