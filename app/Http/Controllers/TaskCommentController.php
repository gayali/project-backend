<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\TaskCommentRequest;
use App\Models\TaskComment;
use App\Enums\ResponseStatus;
use Exception;


class TaskCommentController extends Controller
{
    public function store(TaskCommentRequest $request)
    {
        try {
            TaskComment::create($request->all());
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
            return response()->json(['status'=>ResponseStatus::SUCCESS,'message'=>'Task Comment Edited'], 200);
        } catch (Exception $e) {
            return response()->json(['status'=>ResponseStatus::ERROR,'message'=>$e->getMessage()], 500);
        }
    }
    public function destroy(TaskComment $taskComment)
    {
        try {
            $taskComment->delete();
            return response()->json(['status'=>ResponseStatus::SUCCESS,'message'=>'Task Comment Destroyed'], 200);
        } catch (Exception $e) {
            return response()->json(['status'=>ResponseStatus::ERROR,'message'=>$e->getMessage()], 500);
        }
    }
}
