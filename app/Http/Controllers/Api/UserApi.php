<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserApi extends Controller
{
    public function create(Request $request){
        $data = $request->all();
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'npk' => $data['npk'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);
            $roles = Role::whereIn('id',$data['role'])->get();
            $user->assignRole($roles);
            DB::commit();
            return response()->json([
                'status' => true,
                'msg' => 'User berhasil ditambahkan',
                'data' => [],
            ],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $request->merge(['errors' => $th]);
            return response()->json([
                'status' => false,
                'msg' => 'Gagal menambahkan User',
                'data' => [],
            ],500);
        }
    }
    public function update(Request $request, $id){
        $data = $request->all();
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $user->update([
                'name' => $data['name'],
                'npk' => $data['npk'],
                'email' => $data['email'],
            ]);
            $roles = Role::whereIn('id',$data['role'])->get();
            $user->syncRoles($roles);
            DB::commit();
            return response()->json([
                'status' => true,
                'msg' => 'User berhasil diubah',
                'data' => [],
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $request->merge(['errors' => $th]);
            return response()->json([
                'status' => false,
                'msg' => 'Gagal mengubah user',
                'data' => [],
            ], 500);
        }
    }
    public function delete(Request $request, $id){
        DB::beginTransaction();
        $authUserId = Auth::id();
        if($id == $authUserId){
            return response()->json([
                'status' => false,
                'msg' => 'Gagal menghapus user',
                'data' => [],
            ], 401);
        }
        try {
            User::find($id)->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'msg' => 'User berhasil dihapus',
                'data' => [],
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $request->merge(['errors' => $th]);
            return response()->json([
                'status' => false,
                'msg' => 'Gagal menghapus user',
                'data' => [],
            ], 500);
        }
    }
    public function switchStatus(Request $request,$id){
        $data = $request->all();
        DB::beginTransaction();
        $authUserId = Auth::id();
        if($id == $authUserId){
            return response()->json([
                'status' => false,
                'msg' => 'Gagal mengubah user',
                'data' => [],
            ], 401);
        }
        try {
            User::find($id)->update([
                'is_active' => $data['is_active'] ? 1 : 0,
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'msg' => 'User berhasil diubah',
                'data' => [],
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $request->merge(['errors' => $th]);
            return response()->json([
                'status' => false,
                'msg' => 'Gagal mengubah user',
                'data' => [],
            ], 500);
        }
    }
}
