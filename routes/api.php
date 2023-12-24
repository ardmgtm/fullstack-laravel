<?php

use App\Http\Controllers\Api\RoleAndPermissionApi;
use App\Http\Controllers\Api\UserApi;
use App\Http\Controllers\Api\UserLogApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function(){
    Route::controller(UserApi::class)->group(function () {
        Route::post('/user', 'create')->can('user.create');
        Route::put('/user/{id}', 'update')->can('user.update');
        Route::delete('/user/{id}', 'delete')->can('user.delete');
        Route::put('/user/{id}/switch-status','switchStatus')->can('user.update');
    });
    Route::controller(RoleAndPermissionApi::class)->group(function () {
        Route::post('/role', 'create')->can('role.create');
        Route::put('/role/switch-permission', 'switchPermission')->can('role.assign_permission');
        
        Route::put('/role/{id}', 'update')->can('role.update');
        Route::delete('/role/{id}', 'delete')->can('role.delete');
        Route::get('/role/{id}/permissions','getRolePermission');
    });
});
Route::controller(UserLogApi::class)->group(function(){
    Route::get('user-log/file-list', 'getLogFileList');
    Route::get('user-log/{filename}', 'getLogFileDetail');
});
