<?php

namespace App\Http\Controllers;

use App\Enums\ResponseStatus;
use App\Enums\Role;
use App\Http\Requests\User\NewUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(NewUserRequest $request)
    {
        try {

          $user=  User::create($request->all());
             if($request->role()==Role::ADMIN){
                $user->assignRole(Role::ADMIN);
            }else{
                $user->assignRole(Role::USER);
            }
            return response()->json(['status' => ResponseStatus::SUCCESS, 'message' => 'User Created'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => ResponseStatus::ERROR, 'message' => $e->getMessage()], 500);
        }
    }
    public function user(Request $request)
    {
        try {
            $user = User::find($request->id());
            if ($user) {
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'user' => $user,
                    'message' => 'User Found',
                ], 200);
            }else{
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'user' => null,
                    'message' => 'User Not Found',
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
    public function edit(User $user, UpdateUserRequest $request)
    {
        try {
            $user->update($request->getPayload());
            return response()->json(['status' => ResponseStatus::SUCCESS, 'message' => 'User Edited'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => ResponseStatus::ERROR, 'message' => $e->getMessage()], 500);
        }
    }
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['status' => ResponseStatus::SUCCESS, 'message' => 'User Destroyed'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => ResponseStatus::ERROR, 'message' => $e->getMessage()], 500);
        }
    }
    public function all(Request $request)
    {
        try {
            $users = User::all();
            if ($users) {
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'users' => $users,
                    'message' => 'Users Found',
                ], 200);
            }else{
                return response()->json([
                    'status' => ResponseStatus::SUCCESS,
                    'users' => null,
                    'message' => 'Users Not Found',
                ], 200);
            }

        } catch (Exception $e) {
            return response()->json([
                'status' => ResponseStatus::ERROR,
                'users' => null,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
