<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\ResponseStatus;
use App\Enums\Role;
use App\Http\Requests\SprintRequest;
use App\Models\Sprint;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SprintController extends Controller
{
    public function store(SprintRequest $request)
    {
        try {
            if (Auth::user()->hasRole(Role::ADMIN)) {
                $request = json_decode(json_encode($request->all()), true);
                Log::info($request);
                Sprint::create($request);
                return response()->json(['status' => ResponseStatus::SUCCESS, 'message' => 'Sprint Created'], 200);
            } else {
                return response()->json(['status' => ResponseStatus::ERROR, 'message' => 'Invalid Access'], 401);
            }
        } catch (Exception $e) {
            return response()->json(['status' => ResponseStatus::ERROR, 'message' => $e->getMessage()], 500);
        }
    }
    public function sprints()
    {
        try {

            $sprints = Sprint::all();
            if ($sprints) {
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'sprints' => $sprints,
                    'message' => 'Sprints Found',
                ], 200);
            } else {
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'sprints' => null,
                    'message' => 'Sprints Not Found',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => ResponseStatus::ERROR,
                'sprints' => null,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function sprint(Request $request)
    {
        try {
            $sprint = Sprint::find($request->id())->get();
            if ($sprint) {
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'sprint' => $sprint,
                    'message' => 'Sprint Found',
                ], 200);
            } else {
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'sprint' => null,
                    'message' => 'Sprint Not Found',
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => ResponseStatus::ERROR,
                'sprint' => null,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function activate(Sprint $sprint)
    {
        try {
            if (!Auth::user()->hasRole(Role::ADMIN)) {
                return response()->json(['status' => ResponseStatus::ERROR, 'message' => 'Invalid Access'], 401);
            }

            Sprint::where('project_id', $sprint->project_id)
            ->update([
                'is_active'=>false
            ]);

            Sprint::where('id',  $sprint->id)
            ->update([
                'is_active'=>true
            ]);

            return response()->json(['status' => ResponseStatus::SUCCESS, 'message' => 'Sprint Edited'], 200);

        } catch (Exception $e) {
            return response()->json(['status' => ResponseStatus::ERROR, 'message' => $e->getMessage()], 500);
        }
    }
    public function edit(Sprint $sprint, SprintRequest $request)
    {
        try {

            if (Auth::user()->hasRole(Role::ADMIN)) {
                $sprint->update($request->all());
                return response()->json(['status' => ResponseStatus::SUCCESS, 'message' => 'Sprint Edited'], 200);
            } else {
                return response()->json(['status' => ResponseStatus::ERROR, 'message' => 'Invalid Access'], 401);
            }
        } catch (Exception $e) {
            return response()->json(['status' => ResponseStatus::ERROR, 'message' => $e->getMessage()], 500);
        }
    }
    public function destroy(Sprint $sprint)
    {
        try {

            if (Auth::user()->hasRole(Role::ADMIN)) {
                Task::where('sprint_id',$sprint->id)->update([
                    'sprint_id'=>null
                ]);
                $sprint->delete();
                return response()->json(['status' => ResponseStatus::SUCCESS, 'message' => 'Sprint Destroyed'], 200);
            } else {
                return response()->json(['status' => ResponseStatus::ERROR, 'message' => 'Invalid Access'], 401);
            }
        } catch (Exception $e) {
            return response()->json(['status' => ResponseStatus::ERROR, 'message' => $e->getMessage()], 500);
        }
    }
}
