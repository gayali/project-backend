<?php

namespace App\Http\Controllers;

use App\Enums\ResponseStatus;
use App\Helpers\ProjectHelper;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function store(ProjectRequest $request)
    {
        try {
            $prefix = ProjectHelper::getPrefix($request->project_name);
            $request->request->add(['prefix' =>  $prefix]);
            Log::info($request->all());
            Project::create( $request->all());
            return response()->json(['status' => ResponseStatus::SUCCESS, 'message' => 'Project Created'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => ResponseStatus::ERROR, 'message' => $e->getMessage()], 500);
        }
    }
    public function project(Request $request)
    {
        try {

            $project = Project::find($request->id())->tasks()->get();
            if ($project) {
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'project' => $project,
                    'message' => 'project Found',
                ], 200);
            } else {
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'project' => null,
                    'message' => 'project Not Found',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => ResponseStatus::ERROR,
                'project' => null,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function edit(Project $project, ProjectRequest $request)
    {
        try {
            $project->update($request->getPayload());
            return response()->json(['status' => ResponseStatus::SUCCESS, 'message' => 'Project Edited'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => ResponseStatus::ERROR, 'message' => $e->getMessage()], 500);
        }
    }
    public function destroy(Project $project)
    {
        try {
            $project->delete();
            return response()->json(['status' => ResponseStatus::SUCCESS, 'message' => 'Project Destroyed'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => ResponseStatus::ERROR, 'message' => $e->getMessage()], 500);
        }
    }
    public function projects()
    {
        try {

            $projects = Project::all();
            if ($projects) {
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'projects' => $projects,
                    'message' => 'projects Found',
                ], 200);
            } else {
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'projects' => null,
                    'message' => 'projects Not Found',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => ResponseStatus::ERROR,
                'projects' => null,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
