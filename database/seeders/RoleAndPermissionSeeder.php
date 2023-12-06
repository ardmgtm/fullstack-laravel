<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions name and permissions group with snake case
        $permissionsName = [
            [
                'group_name' => 'user',
                'permissions' => [
                    'browse',
                    'create',
                    'update',
                    'delete',
                ]
            ],
            [
                'group_name' => 'role',
                'permissions' => [
                    'browse',
                    'create',
                    'update',
                    'delete',
                    'assign_permission',
                ]
            ],
        ];

        foreach ($permissionsName as $permissionGroup) {
            $groupName = $permissionGroup['group_name'];
            foreach ($permissionGroup['permissions'] as $permission) {
                Permission::updateOrCreate([
                    'name' => $groupName.'.'.$permission,
                    'guard_name' => 'web'
                ],[]);
            }
        }
    }
}