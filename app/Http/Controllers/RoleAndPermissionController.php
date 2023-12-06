<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RoleAndPermissionController extends Controller
{
    public function roleAndPemissionManagePage(Request $request){
        return Inertia::render('User/RoleAndPermissionManage',[
            'roles' => Role::with(['permissions','users'])->get()
        ]);
    }
}
