<?php

namespace App\Http\Controllers;

use App\Entities\Project;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request) {
        try {
            $query = Project::query();

            if($request->has('name')) {
                $text = '%' . str_replace(' ','%', $request->get('name')) . '%';
                $query = $query->where('name','like', $text);
            }

            $list = $query->orderBy('name')->paginate(parent::$PAGINATE);
            return response($list,200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    public function show($id, Request $request) {
        try {
            $project = Project::find($id);

            if($project == null)
                throw new \Exception('Projecto não encontrado');

            return response($project, 200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    public function store(ProjectCreateRequest $request)
    {
        try {
            $project = new Project();
            $project->fill($request->all());

            $saved = $project->save();
            if(!$saved) {
                throw new \Exception("Não foi possível registrar o Projeto");
            }

            return response($project, 200,['resource_url'=>route('project.show',['id'=>$project->id])]);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

    public function update($id, ProjectUpdateRequest $request)
    {
        try {
            $project = Project::find($id);
            if($project == null)
                throw new \Exception("Projeto não encontrado");

            $project->fill($request->all());
            $saved = $project->save();

            if(!$saved) {
                throw new \Exception("Não foi possível atualizar o Projeto");
            }

            return response($project, 200);
        } catch (\Exception $e) {
            return response(['message'=>$e->getMessage()],404);
        }
    }

}
