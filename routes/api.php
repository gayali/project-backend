<?php

use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', 'AuthController@login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/me', 'AuthController@me');

    Route::group(['middleware' => ['role:'.Role::ADMIN]], function () {
        Route::group(['prefix' => 'users'], function () {
            Route::post('', 'UserController@store');
            Route::get('all', 'UserController@all');
            Route::get('/{user}/show', 'UserController@user');
            Route::post('/{user}/edit', 'UserController@edit');
            Route::post('/{user}/destroy', 'UserController@destroy');
        });
        Route::group(['prefix' => 'projects'], function () {
            Route::post('', 'ProjectController@store');
            Route::get('', 'ProjectController@projects');
            Route::get('/{project}/show', 'ProjectController@project');
            Route::post('/{project}/edit', 'ProjectController@edit');
            Route::post('/{project}/destroy', 'ProjectController@destroy');
        });
        Route::group(['prefix' => 'tasks'], function () {
            Route::post('', 'TaskController@store');
            Route::get('', 'TaskController@tasks');
            Route::get('/{task}/show', 'TaskController@task');
            Route::post('/{task}/edit', 'TaskController@edit');
            Route::post('/{task}/destroy', 'TaskController@destroy');
        });
        Route::group(['prefix' => 'taskComments'], function () {
            Route::post('', 'TaskComment@store');
            Route::get('/{taskComment}/show', 'TaskComment@taskComment');
            Route::post('/{taskComment}/edit', 'TaskComment@edit');
            Route::post('/{taskComment}/destroy', 'TaskComment@destroy');
        });
    });

    Route::group(['middleware' => ['role:'.Role::USER.'|'.Role::ADMIN]], function () {

        Route::group(['prefix' => 'users'], function () {
            Route::get('/{user}/show', 'UserController@user');
        });
        Route::group(['prefix' => 'projects'], function () {
            Route::get('/{project}/show', 'ProjectController@project');
        });
        Route::group(['prefix' => 'tasks'], function () {
            Route::get('/{task}/show', 'TaskController@task');
            Route::post('/{task}/edit', 'TaskController@edit');
        });
        Route::group(['prefix' => 'taskComments'], function () {
            Route::post('', 'TaskComment@store');
            Route::get('/{taskComment}/show', 'TaskComment@taskComment');
            Route::post('/{taskComment}/edit', 'TaskComment@edit');
        });
    });
});
