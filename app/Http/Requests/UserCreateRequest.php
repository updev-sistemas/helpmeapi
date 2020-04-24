<?php

namespace App\Http\Requests;

use App\Types\UserType;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    public function authorize()
    {
        $user = request()->user();
        if($user == null)
            return false;
        return $user->paper_id == UserType::ADMINISTRATOR;
    }

    public function rules()
    {
        return [
            'email'=>'required|max:120|unique:users',
            'enterprise_id'=>'required|exists:enterprises,id',
            'paper_id'=>'required|exists:system_class,id'
        ];
    }

    public function messages()
    {
        return [
            'email.email'=>'Email inválido',
            'email.max'=>'Email com até 120 caracteres',
            'email.unique'=>'Email já está registrado',
            'enterprise_id.required'=>'Informe a empresa',
            'enterprise_id.exists'=>'Empresa não foi encontrada',
            'paper_id.required'=>'Informe o Tipo de Usuário',
            'paper_id.exists'=>'Tipo não encontrado'
        ];
    }
}
