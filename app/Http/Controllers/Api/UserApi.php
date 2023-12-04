<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserApi extends Controller
{
    public function create(Request $request){
        $data = $request->all();
        DB::beginTransaction();
        try {
            User::create([
                'name' => $data['name'],
                'npk' => $data['npk'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'msg' => 'User berhasil ditambahkan',
                'data' => [],
            ],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'msg' => 'Gagal menambahkan User',
                'data' => [],
            ],400);
        }
    }
    public function update(Request $request, $id){
        $data = $request->all();
        DB::beginTransaction();
        try {
            User::find($id)->update([
                'name' => $data['name'],
                'npk' => $data['npk'],
                'email' => $data['email'],
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'msg' => 'User berhasil diubah',
                'data' => [],
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'msg' => 'Gagal mengubah user',
                'data' => [],
            ], 400);
        }
    }
    public function delete(Request $request, $id){
        DB::beginTransaction();
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
            return response()->json([
                'status' => false,
                'msg' => 'Gagal menghapus user',
                'data' => [],
            ], 400);
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
            ], 400);
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
            return response()->json([
                'status' => false,
                'msg' => 'Gagal mengubah user',
                'data' => [],
            ], 400);
        }
    }
}
