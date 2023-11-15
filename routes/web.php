<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/login',[AuthenticationController::class,'loginPage'])->name('login')->middleware('guest');
Route::post('/login',[AuthenticationController::class,'login']);

Route::middleware(['auth'])->group(function () {
    Route::post('/logout',[AuthenticationController::class,'logout']);
    
    Route::get('/', function () {
        return redirect('/dashboard');
    });
    
    Route::get('/dashboard', function () {
        return Inertia::render('Home',[]);
    });
    Route::get('/report/daily', function () {
        return Inertia::render('Report/DailyReport',[]);
    });
});