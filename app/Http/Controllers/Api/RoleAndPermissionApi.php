<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleAndPermissionApi extends Controller
{
    public function create(Request $request){
        $data = $request->all();
        DB::beginTransaction();
        try {
            Role::create([
                'name' => $data['name'],
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'msg' => 'Role berhasil ditambahkan',
                'data' => [],
            ],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'msg' => 'Gagal menambahkan Role',
                'data' => [],
            ],400);
        }
    }
    public function update(Request $request, $id){
        $data = $request->all();
        DB::beginTransaction();
        try {
            Role::find($id)->update([
                'name' => $data['name'],
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'msg' => 'Role berhasil diubah',
                'data' => [],
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'msg' => 'Gagal mengubah role',
                'data' => [],
            ], 400);
        }
    }
    public function delete(Request $request, $id){
        DB::beginTransaction();
        try {
            $role = Role::where('id',$id);
            $role->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'msg' => 'Role berhasil dihapus',
                'data' => [],
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return response()->json([
                'status' => false,
                'msg' => 'Gagal menghapus role',
                'data' => [],
            ], 400);
        }
    }
}
