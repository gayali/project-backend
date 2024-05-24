<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\TaskCommentRequest;
use App\Models\TaskComment;
use App\Enums\ResponseStatus;
use App\Helpers\NotificationMessage;
use App\Models\Task;
use App\Notifications\UpdateToSlack;
use Exception;
use Illuminate\Support\Facades\Notification;

class TaskCommentController extends Controller
{
    public function store(TaskCommentRequest $request)
    {
        try {
            $taskId=Task::where('branch_name',$request->task_branch_name)->first()->id;

            $request->request->add(['task_id' =>  $taskId]);

            $taskComment= TaskComment::create($request->all());

            $message=NotificationMessage::taskCommentCreated($taskComment);
            Notification::route('slack',env('SLACK_HOOK'))
                ->notify(new UpdateToSlack($message));

            return response()->json(['status'=>ResponseStatus::SUCCESS,'message'=>'Task Created'], 200);
        } catch (Exception $e) {
            return response()->json(['status'=>ResponseStatus::ERROR,'message'=>$e->getMessage()], 500);
        }
    }
    public function taskComment(Request $request)
    {
        try {
            $taskComment = TaskComment::find($request->id());

            if ($taskComment) {
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'taskComment' => $taskComment,
                    'message' => 'Task Comment Found',
                ], 200);
            }else{
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'taskComment' => null,
                    'message' => 'Task Comment Not Found',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'=>ResponseStatus::ERROR,
                'taskComment'=>null,
                'message'=>  $e->getMessage()
            ], 500);
        }
    }
    public function fetchAll(Request $request)
    {
        try {
            $taskComments = TaskComment::where("task_id",$request->task_id)->get();
            if ($taskComments) {
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'taskComments' => $taskComments,
                    'message' => 'Task Comment Found',
                ], 200);
            }else{
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'taskComments' => null,
                    'message' => 'Task Comments Not Found',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'=>ResponseStatus::ERROR,
                'taskComments'=>null,
                'message'=>  $e->getMessage()
            ], 500);
        }
    }
    public function edit(TaskComment $taskComment,TaskCommentRequest $request)
    {
        try {
            $taskComment->update($request->getPayload());
            $message=NotificationMessage::taskCommentEdited($taskComment);
            Notification::route('slack',env('SLACK_HOOK'))
                ->notify(new UpdateToSlack($message));
            return response()->json(['status'=>ResponseStatus::SUCCESS,'message'=>'Task Comment Edited'], 200);
        } catch (Exception $e) {
            return response()->json(['status'=>ResponseStatus::ERROR,'message'=>$e->getMessage()], 500);
        }
    }
    public function destroy(TaskComment $taskComment)
    {
        try {
            $message=NotificationMessage::taskCommentDeleted($taskComment);
            Notification::route('slack',env('SLACK_HOOK'))
                ->notify(new UpdateToSlack($message));
            $taskComment->delete();
            return response()->json(['status'=>ResponseStatus::SUCCESS,'message'=>'Task Comment Destroyed'], 200);
        } catch (Exception $e) {
            return response()->json(['status'=>ResponseStatus::ERROR,'message'=>$e->getMessage()], 500);
        }
    }
}
