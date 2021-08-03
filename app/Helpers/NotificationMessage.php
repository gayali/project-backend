<?php

namespace App\Helpers;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Support\Facades\Auth;

class NotificationMessage
{
    public static function projectCreated(Project $project)
    {        
        $user=Auth::user();
        $roles =json_decode(json_encode($user->getRoleNames()), true); 
        $roles = implode(", ",$roles);

        $string=$roles." : ".$user->name." has:\n";
        return $string."Created new project : '". $project->project_name."'";
    }
    public static function projectEdited(Project $project)
    {        
        $user=Auth::user();
        $roles =json_decode(json_encode($user->getRoleNames()), true); 
        $roles = implode(", ",$roles);

        $string=$roles." : ".$user->name." has:\n";
        return $string."Edited project : '". $project->project_name."'";
    }
    public static function projectDeleted(Project $project)
    {        
        $user=Auth::user();
        $roles =json_decode(json_encode($user->getRoleNames()), true); 
        $roles = implode(", ",$roles);

        $string=$roles." : ".$user->name." has:\n";
        return $string."Deleted project : '". $project->project_name."'";
    }
    

    public static function taskCreated(Task $task)
    {        
        
        $user=Auth::user();
        $roles =json_decode(json_encode($user->getRoleNames()), true); 
        $roles = implode(", ",$roles);

        $string=$roles." : ".$user->name." has:\n";
        return $string."Created new task : '". $task->task_title."'";
    }
    public static function taskEdited(Task $task)
    {        
        
        $user=Auth::user();
        $roles =json_decode(json_encode($user->getRoleNames()), true); 
        $roles = implode(", ",$roles);

        $string=$roles." : ".$user->name." has:\n";
        return $string."Edited task : '". $task->task_title."'";
    }
    public static function taskDeleted(Task $task)
    {        
        $user=Auth::user();
        $roles =json_decode(json_encode($user->getRoleNames()), true); 
        $roles = implode(", ",$roles);

        $string=$roles." : ".$user->name." has:\n";
        return $string."Deleted task : '". $task->task_title."'";
    }




    
    public static function taskCommentCreated(TaskComment $taskComment)
    {        
        
        $user=Auth::user();
        $roles =json_decode(json_encode($user->getRoleNames()), true); 
        $roles = implode(", ",$roles);

        $string=$roles." : ".$user->name." has:\n";
        $string=  $string."Created new task comment: '". strip_tags($taskComment->comment)."'\n";
        return  $string."On task : ".$taskComment->task->task_title.", For project : ".$taskComment->task->project->project_name;
    }
    public static function taskCommentEdited(TaskComment $taskComment)
    {        
        
        $user=Auth::user();
        $roles =json_decode(json_encode($user->getRoleNames()), true); 
        $roles = implode(", ",$roles);

        $string=$roles." : ".$user->name." has:\n";
        $string=  $string."Edited task comment: '". strip_tags($taskComment->comment)."'\n";
        return  $string."On task : ".$taskComment->task->task_title.", For project : ".$taskComment->task->project->project_name;
  
    }
    public static function taskCommentDeleted(TaskComment $taskComment)
    {        
        $user=Auth::user();
        $roles =json_decode(json_encode($user->getRoleNames()), true); 
        $roles = implode(", ",$roles);

        $string=$roles." : ".$user->name." has:\n";
        $string=  $string."Deleted task comment: '". strip_tags($taskComment->comment)."'\n";
        return  $string."On task : ".$taskComment->task->task_title.", For project : ".$taskComment->task->project->project_name;
  
    }
}
