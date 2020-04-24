<?php

namespace App\Http\Requests;

use App\Types\UserType;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EnterpriseCreateRequest extends FormRequest
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
            'name'=>'required|max:200',
            'image'=>'nullable',
            'document'=>'required|min:11|max:14|unique:enterprises,document',
            'email'=>'nullable|email|max:120',
            'phone'=>'nullable|max:20',
            'address_name'=>'nullable|max:200',
            'address_district'=>'nullable|max:100',
            'address_cep'=>'nullable|max:20',
            'address_city'=>'nullable|max:200',
            'address_state_uf'=>'nullable|max:2',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Informe o Nome',
            'name.max'=>'Nome com até 200 caracteres',
            'document.required'=>'Informe o documento',
            'document.min'=>'Documento Inválido',
            'document.max'=>'Documento Inválido',
            'document.unique'=>'Documento já está registrado',
            'email.email'=>'Email inválido',
            'email.max'=>'Email com até d120 caracteres',
            'phone.max'=>'Telefone com até 20 caracteres',
            'address_name.max'=>'Endereço com até 200 caracteres',
            'address_district.max'=>'Endereço com até 100 caracteres',
            'address_cep.max'=>'Endereço com até 20 caracteres',
            'address_city.max'=>'Nome com até 200 caracteres',
            'address_state_uf.max'=>'Sigla com até 2 caracteres',
        ];
    }
}
