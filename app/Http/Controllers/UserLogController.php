<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserLogController extends Controller
{
    public function userLogPage(Request $request){
        return Inertia::render('User/UserLogManage',[]);
    }
}
