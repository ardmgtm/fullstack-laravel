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
        Route::post('/user', 'create');
        Route::put('/user/{id}', 'update');
        Route::delete('/user/{id}', 'delete');
        Route::put('/user/{id}/switch-status','switchStatus');
    });
    Route::controller(RoleAndPermissionApi::class)->group(function () {
        Route::post('/role', 'create');
        Route::put('/role/switch-permission', 'switchPermission');
        
        Route::put('/role/{id}', 'update');
        Route::delete('/role/{id}', 'delete');
        Route::get('/role/{id}/permissions','getRolePermission');
    });
});
Route::controller(UserLogApi::class)->group(function(){
    Route::get('user-log/file-list', 'getLogFileList');
    Route::get('user-log/{filename}', 'getLogFileDetail');
});
