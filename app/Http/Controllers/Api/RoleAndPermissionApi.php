<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionApi extends Controller
{
    public function create(Request $request){
        $data = $request->all();
        DB::beginTransaction();
        try {
            Role::create([
                'name' => $data['name'],
                'guard_name' => 'web',
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
            return response()->json([
                'status' => false,
                'msg' => 'Gagal menghapus role',
                'data' => [],
            ], 400);
        }
    }
    public function getRolePermission(Request $request, $id){
        $roleId = $id;

        $permissions = Permission::select('id', 'name')
            ->leftJoin('role_has_permissions', function ($join) use ($roleId) {
                $join->on('permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where('role_has_permissions.role_id', '=', $roleId);
            })
            ->addSelect(DB::raw('CASE WHEN role_has_permissions.role_id IS NOT NULL THEN TRUE ELSE FALSE END AS role_has_permission'))
            ->orderBy('id')
            ->get();

        $permissionsGrouped = $permissions->groupBy(function ($item) {
            return explode('.', $item['name'])[0];
        });

        return response()->json([
            'status' => true,
            'msg' => 'Berhasil mengambil data permission',
            'data' => [
                'permissions' => $permissionsGrouped,
                'total_assigned_permission' => $permissions->where('role_has_permission', 1)->count(),
            ],
        ], 200);
    }
    public function switchPermission(Request $request){
        $data = $request->all();
        DB::beginTransaction();
        try {
            $role = Role::find($data['id_role']);
            $permission = Permission::find($data['id_permission']);
            if($data['value']){
                $role->givePermissionTo($permission);
            }else{
                $role->revokePermissionTo($permission);
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'msg' => 'Role permission berhasil diubah',
                'data' => [],
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'msg' => 'Gagal mengubah role permission',
                'data' => $th,
            ], 400);
        }
    }
}
