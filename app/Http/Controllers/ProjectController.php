<?php

namespace App\Http\Controllers;

use App\Enums\ResponseStatus;
use App\Helpers\NotificationMessage;
use App\Helpers\ProjectHelper;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskComment;
use App\Notifications\UpdateToSlack;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ProjectController extends Controller
{
    public function store(ProjectRequest $request)
    {
        try {
            $prefix = ProjectHelper::getPrefix($request->project_name);
            $request->request->add(['prefix' =>  $prefix]);
            $project=Project::create( $request->all());

            
            $message=NotificationMessage::projectCreated($project);
            Notification::route('slack',env('SLACK_HOOK'))
                ->notify(new UpdateToSlack($message));

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
            $project->update($request->all());
            $message=NotificationMessage::projectEdited($project);
            Notification::route('slack',env('SLACK_HOOK'))
                ->notify(new UpdateToSlack($message));
            return response()->json(['status' => ResponseStatus::SUCCESS, 'message' => 'Project Edited'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => ResponseStatus::ERROR, 'message' => $e->getMessage()], 500);
        }
    }
    public function destroy(Project $project)
    {
        try {
            $tasks=Task::where('project_id',$project->id)->get();
            foreach ($tasks as $task) {
                TaskComment::where('task_id',$task->id)->delete();
            }

            Task::where('project_id',$project->id)->delete();
            $message=NotificationMessage::projectDeleted($project);
            Notification::route('slack',env('SLACK_HOOK'))
                ->notify(new UpdateToSlack($message));
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
