<?php

namespace App\Http\Requests;

use App\Types\UserType;
use Illuminate\Foundation\Http\FormRequest;

class ProjectUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = request()->user();
        if($user != null) {
            return $user->type->id == UserType::ADMINISTRATOR || $user->type->id == UserType::SUPERVISOR_A;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|min:2|max:200',
            'image'=>'nullable|file|mime:jpg,png',
            'initials'=>'required|min:2|max:10|unique:projects,initials,' . $this->route('id'),
            'description'=>'nullable|string',
            'enterprise_id'=>'nullable|exists:enterprises,id',
            'supervisor_id'=>'nullable|exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'Informe o Nome',
            'name.min'=>'Mínimo de 2 caracteres',
            'name.max'=>'Máximo de 200 caracteres',
            'image.file'=>'Arquivo inválido',
            'image.mime'=>'Tipo de imagem inválida',
            'initials.required'=>'Sigla do Projeto Necessária',
            'initials.min'=>'Mínimo de 2 caracteres',
            'initials.max'=>'Máximo de 10 caracteres',
            'initials.unique'=>'Essa Sigla já está registrada',
            'description.string'=>'Escreva uma breve descrição sobre o projeto',
            'enterprise_id.exists'=>'Empresa não encontrada',
            'supervisor_id.exists'=>'Supervisor não encontrado'
        ];
    }
}
