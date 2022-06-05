<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

final class RolesAndPermissionsSeeder extends Seeder
{
    private $addressPermissions = [
        'create_addresses',
        'delete_addresses',
        'list_addresses',
        'update_addresses',
    ];

    private $authPermissions = [
        'change_user_password',
        'create_tokens',
        'list_permissions',
        'list_roles',
        'list_users',
        'update_user',
    ];

    private $mediaPermissions = [
        'delete_media',
        'download_media',
        'upload_media',
    ];

    private $rolePermissions = [
        'assign_permissions',
        'create_roles',
        'delete_roles',
        'list_role_permissions',
        'update_roles',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::with('permission')->delete();
        Permission::with('role')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Permission::insert(array_map(
            fn ($permission) => ['guard_name' => 'web', 'name' => $permission],
            $this->getAllPermissions()
        ));

        $this->createRole('guest')->givePermissionTo(
            'change_user_password',
            'list_items',
            'list_purchase_orders',
            'list_variants',
            'update_user',
        );

        $this->createRole('super_admin')->givePermissionTo($this->getAllPermissions());
    }

    private function getAllPermissions()
    {
        return array_merge(
            $this->addressPermissions,
            $this->authPermissions,
            $this->mediaPermissions,
            $this->rolePermissions,
        );
    }

    private function createRole(string $roleName): Role
    {
        return Role::create(['name' => $roleName]);
    }
}
