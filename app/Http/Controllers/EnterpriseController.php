<?php

namespace App\Http\Controllers;

use App\Entities\Enterprise;
use App\Http\Requests\EnterpriseCreateRequest;
use App\Http\Requests\EnterpriseUpdateRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;

class EnterpriseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request) {
        try {
            $query = Enterprise::query();

            if($request->has('name')) {
                $text = '%' . str_replace(' ', '%',$request->get('name')) . '%';
                $query = $query->where('name','like', $text);
            }

            if($request->has('city')) {
                $text = '%' . str_replace(' ', '%',$request->get('city')) . '%';
                $query = $query->where('address_city','like', $text);
            }

            if($request->has('state')) {
                $query = $query->where('address_state_uf','=', $request->get('state'));
            }

            if($request->has('status')) {
                $query = $query->where('status_id','=', $request->get('status'));
            }

            if($request->has('document')) {
                $query = $query->where('document','=', $request->get('document'));
            }

            $list = $query->orderBy('created_at')->paginate(parent::$PAGINATE);
            return response($list,200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    public function show($id, Request $request) {
        try {
            $enterprise = Enterprise::find($id);

            if($enterprise == null)
                throw new \Exception('Empresa não encontrada');

            return response($enterprise, 200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    public function store(EnterpriseCreateRequest $request)
    {
        try {
            $enterprise = new Enterprise();
            $enterprise->fill($request->all());
            $saved = $enterprise->save();
            if(!$saved) {
                throw new \Exception("Não foi possível registrar a Empresa");
            }

            return response($enterprise, 200,['resource_url'=>route('enterprise.show',['id'=>$enterprise->id])]);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    public function update($id, EnterpriseUpdateRequest $request)
    {
        try {
            $enterprise = Enterprise::find($id);
            if($enterprise == null)
                throw new \Exception("Empresa não encontrada");

            $enterprise->fill($request->all());
            $saved = $enterprise->save();

            if(!$saved) {
                throw new \Exception("Não foi possível atualizar a Empresa");
            }

            return response($enterprise, 200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }
}
