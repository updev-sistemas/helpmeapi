<?php

namespace App\Http\Controllers;

use App\Entities\Task;
use App\Types\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $params = [
            'ticket_number',
            'title',
            'customer_report',
            'technical_report',
            'expected_time_hours','expected_time_minute',
            'hour_worked_hours',
            'hour_worked_minute',
            'started_at',
            'finish_at',
            'reporter_id',
            'project_id',
            'enterprise_id',
            'technician_id',
            'supervisor_id',
            'priority',
            'status_id',
            'type_id'
        ];
    }

    public function index(Request $request) {
        try {
            $query = Task::query();

            if($request->has('enterprise')) {
                $query = $query->where('enterprise_id','=', $request->get('enterprise'));
            }

            if($request->has('supervisor')) {
                $query = $query->where('supervisor_id','=', $request->get('supervisor'));
            }

            if($request->has('technician')) {
                $query = $query->where('technician_id','=', $request->get('technician'));
            }

            if($request->has('project')) {
                $query = $query->where('project_id','=', $request->get('project'));
            }

            if($request->has('status')) {
                $query = $query->where('status_id','=', $request->get('status'));
            }

            if($request->has('type')) {
                $query = $query->where('type_id','=', $request->get('type'));
            }

            /**
             * @TODO Filtrar pela Data colocando 00:00:00 até as 23:59:59
             */
            if($request->has('initial_date') && $request->has('finish_date')) {
                $query = $query->whereBetween('created_at',[
                    $request->get('initial_date'),
                    $request->get('finish_date')
                ]);
            }

            $list = $query->orderBy('created_at')->paginate(parent::$PAGINATE);
            return response($list,200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    private function storeByAdministrator(Request $request)
    {
        try {
            $data = $request->except(['_token','_method']);
            $task = new Task($data);
            $saved = $task->save();
            if(!$saved)
                throw new \Exception("Não foi possível registrar a Chamada");

            return response($task, 200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    private function storeBySupervisor(Request $request)
    {
        try {
            $data = $request->except(['_token','_method']);
            $task = new Task($data);
            $saved = $task->save();
            if(!$saved)
                throw new \Exception("Não foi possível registrar a Chamada");

            return response($task, 200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    private function storeByCustomer(Request $request)
    {
        try {
            $data = $request->except(['_token','_method']);
            $task = new Task($data);
            $saved = $task->save();
            if(!$saved)
                throw new \Exception("Não foi possível registrar a Chamada");

            return response($task, 200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    public function store(Request $request)
    {
        try {

            $user = $request->user();
            if($user == null)
                throw new \Exception("Sem Autorização para essa ação");

            if($user->type->id == UserType::ADMINISTRATOR)
                return $this->storeByAdministrator($request);

            if($user->type->id == UserType::SUPERVISOR_A || $user->type->id == UserType::SUPERVISOR_B)
                return $this->storeBySupervisor($request);

            if($user->type->id == UserType::CUSTOMER)
                return $this->storeByCustomer($request);

            return response(null, 200,['resource_url'=>route('enterprise.show',['id'=>null])]);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    private function updateByAdministrator($taskId, Request $request)
    {
        try {
            $data = $request->except(['_token','_method']);
            $task = Task::find($taskId);
            if($task == null)
                throw new \Exception("Chamada não encontrada");

            $task->fill($data);
            $saved = $task->update();
            if(!$saved)
                throw new \Exception("Não foi possível atualizar a Chamada");

            return response($task, 200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    private function updateBySupervisor($taskId, Request $request)
    {
        try {
            $data = $request->except(['_token','_method']);
            $task = Task::find($taskId);
            if($task == null)
                throw new \Exception("Chamada não encontrada");

            $task->fill($data);
            $saved = $task->update();
            if(!$saved)
                throw new \Exception("Não foi possível atualizar a Chamada");

            return response($task, 200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    private function updateByCustomer($taskId, Request $request)
    {
        try {
            $data = $request->except(['_token','_method']);
            $query = Task::query();

            $query = $query->where('customer_report','=', Auth::id());

            $task = $query->first();

            if($task == null)
                throw new \Exception("Chamada não encontrada");

            $task->fill($data);
            $saved = $task->update();
            if(!$saved)
                throw new \Exception("Não foi possível atualizar a Chamada");

            return response($task, 200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    public function update($taskId, Request $request)
    {
        try {

            $user = $request->user();
            if($user == null)
                throw new \Exception("Sem Autorização para essa ação");

            if($user->type->id == UserType::ADMINISTRATOR)
                return $this->storeByAdministrator($request);

            if($user->type->id == UserType::SUPERVISOR_A || $user->type->id == UserType::SUPERVISOR_B)
                return $this->storeBySupervisor($request);

            if($user->type->id == UserType::CUSTOMER)
                return $this->storeByCustomer($request);

            return response(null, 200,['resource_url'=>route('enterprise.show',['id'=>null])]);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }
}
