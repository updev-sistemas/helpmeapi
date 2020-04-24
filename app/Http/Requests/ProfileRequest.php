<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = request()->user();
        return $user != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|max:100',
            'photo'=>'nullable|file|mimes:jpeg,png',
            'email'=>'required|email|max:120|unique:users,email,' . request()->user()->id,
            'username'=>'required|min:3|max:20|unique:users,username,' . request()->user()->id,
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Informe o Nome',
            'name.max'=>'Nome deve ter até 100 caracteres',
            'photo.file'=>'Arquivo Inválido',
            'photo.mimes'=>'Tipo de foto não aceito (Somente JPG e PNG)',
            'email.required'=>'Informe o Email',
            'email.email'=>'Email inválido',
            'email.max'=>'Email com até 120 caracteres',
            'email.unique'=>'Email já está registrado',
            'username.required'=>'Informe o Username',
            'username.min'=>'Usuário com pelo menos 3 caracteres',
            'username.max'=>'Usuário com até 20 caracteres',
            'username.unique'=>'Usuário já registrado',
        ];
    }
}
