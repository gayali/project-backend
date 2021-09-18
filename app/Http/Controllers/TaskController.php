<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\NotificationMessage;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Enums\ResponseStatus;
use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\TaskComment;
use App\Notifications\UpdateToSlack;
use Illuminate\Support\Facades\Notification;
use Exception;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function store(TaskRequest $request)
    {
        try {
            $request=json_decode(json_encode($request->all()),true);
            
            $latestTask=Task::where('project_id',$request['project_id'])->orderBy('created_at','desc')->first();

            $latestTaskStringArray=explode("-",$latestTask->branch_name);
            $newTaskNumber= intval(end($latestTaskStringArray))+1;

            $project=Project::find($request['project_id']);
            $request['branch_name']= $project->prefix.'-'.strval($newTaskNumber);
            $request['status']=TaskStatus::BACKLOG;
            $task=Task::create($request);
            $message=NotificationMessage::taskCreated($task);
            Notification::route('slack',env('SLACK_HOOK'))
                ->notify(new UpdateToSlack($message));
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
            $task->update($request->all());
            $message=NotificationMessage::taskEdited($task);
            Notification::route('slack',env('SLACK_HOOK'))
                ->notify(new UpdateToSlack($message));
            return response()->json(['status'=>ResponseStatus::SUCCESS,'message'=>'Task Edited'], 200);
        } catch (Exception $e) {
            return response()->json(['status'=>ResponseStatus::ERROR,'message'=>$e->getMessage()], 500);
        }
    }
    public function destroy(Task $task)
    {
        try {
           TaskComment::where('task_id',$task->id)->delete();
            $message=NotificationMessage::taskDeleted($task);
            Notification::route('slack',env('SLACK_HOOK'))
                ->notify(new UpdateToSlack($message));
            $task->delete();
            return response()->json(['status'=>ResponseStatus::SUCCESS,'message'=>'Task Destroyed'], 200);
        } catch (Exception $e) {
            return response()->json(['status'=>ResponseStatus::ERROR,'message'=>$e->getMessage()], 500);
        }
    }
}
