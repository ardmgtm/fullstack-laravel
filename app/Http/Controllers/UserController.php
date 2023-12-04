<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\DxAdapter;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function userManagePage(Request $request){
        return Inertia::render('User/UserManage',[
            'dataProcessingUrl' => url('/user/data-processing'),
        ]);
    }
    public function dataProcessing(Request $request){
        $loadData = User::select('*');
        $loadDatais = DxAdapter::load($loadData);
        $data = $loadDatais->paginate($request->take ?? $loadDatais->count());
        return response()->json([
            'status' => true,
            'data' => $data->items(),
            'totalCount' => $data->total(),
        ], 200);
    }
}
 