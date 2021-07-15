<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Enums\ResponseStatus;
use App\Enums\TaskStatus;
use App\Models\Project;
use Exception;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function store(TaskRequest $request)
    {
        try {
            $request=json_decode(json_encode($request->all()),true);

            $newTaskNumber=(Task::where('project_id',$request['project_id'])->get()->count())+1;
            $project=Project::find($request['project_id']);
            $request['branch_name']= $project->prefix. strval($newTaskNumber);
            $request['status']=TaskStatus::BACKLOG;
            Task::create($request);
            return response()->json(['status'=>ResponseStatus::SUCCESS,'message'=>'Task Created'], 200);
        } catch (Exception $e) {
            return response()->json(['status'=>ResponseStatus::ERROR,'message'=>$e->getMessage()], 500);
        }
    }
    public function tasks()
    {
        try {

            $tasks = Task::all();
            if ($tasks) {
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'tasks' => $tasks,
                    'message' => 'Tasks Found',
                ], 200);
            } else {
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'tasks' => null,
                    'message' => 'Tasks Not Found',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => ResponseStatus::ERROR,
                'tasks' => null,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function task(Request $request)
    {
        try {
            $task = Task::find($request->id())->taskComments()->get();
            if ($task) {
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'task' => $task,
                    'message' => 'Task Found',
                ], 200);
            }else{
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'task' => null,
                    'message' => 'Task Not Found',
                ], 200);
            }

        } catch (Exception $e) {
            return response()->json([
                'status' => ResponseStatus::ERROR,
                'user' => null,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function edit(Task $task,TaskRequest $request)
    {
        try {
            $task->update($request->getPayload());
            return response()->json(['status'=>ResponseStatus::SUCCESS,'message'=>'Task Edited'], 200);
        } catch (Exception $e) {
            return response()->json(['status'=>ResponseStatus::ERROR,'message'=>$e->getMessage()], 500);
        }
    }
    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return response()->json(['status'=>ResponseStatus::SUCCESS,'message'=>'Task Destroyed'], 200);
        } catch (Exception $e) {
            return response()->json(['status'=>ResponseStatus::ERROR,'message'=>$e->getMessage()], 500);
        }
    }
}
