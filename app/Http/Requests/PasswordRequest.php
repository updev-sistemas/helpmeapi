<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password_old'=>'required|string',
            'password_new'=>'required|string|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'password_old.required'=>'Informe a senha Atual',
            'password_old.string'=>'Senha Inválida',
            'password_new.required'=>'Informe a nova senha',
            'password_new.string'=>'Senha Inválida',
            'password.confirmed'=>'Senhas não conferem'
        ];
    }
}
