<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserCreateRequest;
use App\User;
use App\Http\Requests\EnterpriseCreateRequest;
use App\Http\Requests\EnterpriseUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use phpseclib\Crypt\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request) {
        try {
            $query = User::query();

            if($request->has('name')) {
                $text = '%' . str_replace(' ', '%',$request->get('name')) . '%';
                $query = $query->where('name','like', $text);
            }

            if($request->has('username')) {
                $text = '%' . str_replace(' ', '%',$request->get('username')) . '%';
                $query = $query->where('username','like', $text);
            }

            if($request->has('email')) {
                $query = $query->where('name','=', $request->get('email'));
            }

            if($request->has('status')) {
                $query = $query->where('status_id','=', $request->get('status'));
            }

            if($request->has('enterprise')) {
                $query = $query->where('enterprise_id','=', $request->get('enterprise'));
            }

            if($request->has('type')) {
                $query = $query->where('paper_id','=', $request->get('type'));
            }

            if($request->has('dt_min') && $request->has('dt_max')) {
                $dt1 = Carbon::parse($request->get('dt_min'))->format("Y-m-d");
                $dt2 = Carbon::parse($request->get('dt_max'))->format("Y-m-d");
                $query = $query->whereBetween('created_at',[$dt1, $dt2]);
            }

            $list = $query->orderBy('created_at')->paginate(parent::$PAGINATE);
            return response($list,200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    public function show($id, Request $request) {
        try {
            $user = User::find($id);

            if($user == null)
                throw new \Exception('Usuário não encontrado');

            return response($user, 200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    public function store(UserCreateRequest $request)
    {
        try {

            $data = [
                'name'=>'User Name',
                'photo'=>'user-default.png',
                'email'=>$request->get('email'),
                'username'=>time(),
                'paper_id'=>$request->get('paper_id'),
                'enterprise_id'=>$request->get('enterprise_id'),
                'status_id'=>-703,
                'password'=>'!A$B@C%D&1*2(3)4_5-AAAA_BBBB_CCCC_DDDD_EEEE_FFFF_$$$$@GET_USER-AJOFIHEUION81KLF&(GEUNDHUH41'
            ];

            $user = new User();
            $user->fill($data);
            $saved = $user->save();
            if(!$saved) {
                throw new \Exception("Não foi possível registrar o Usuário");
            }

            return response($user, 200,['resource_url'=>route('user.show',['id'=>$user->id])]);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    public function getProfile(Request $request)
    {
        try {
            $user = request()->user();
            if($user == null) {
                return response(['message' => 'Falha de Autenticação'], 401);
            } else {
                return response($user->toArray(), 200);
            }
        } catch (\Exception $e) {
            return response(["message"=>$e->getMessage()], 404);
        }
    }

    public function setProfile(ProfileRequest $request) {
        try {
            $user = request()->user();

            $user->fill($request->only(["name","email","username"]));
            $saved = $user->save();

            if(!$saved)
                throw new \Exception("Ocorreu um erro ao salvar seu perfil");
            return response(null, 200);
        } catch (\Exception $e) {
            return response(["message"=>$e->getMessage()], 404);
        }
    }

    public function changePassword(PasswordRequest $request) {
        try {
            $user = request()->user();
            $user->password = \Illuminate\Support\Facades\Hash::make($request->get('password_new'));
            $user->last_change_password = Carbon::now()->format('Y-m-d H:i:s');
            $saved = $user->save();
            if(!$saved)
                throw new \Exception("Ocorreu um erro ao modificar a senha");
            return response(null, 200);
        } catch (\Exception $e) {
            return response(["message"=>$e->getMessage()], 404);
        }
    }
}
