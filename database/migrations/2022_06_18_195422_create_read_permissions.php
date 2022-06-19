<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateReadPermissions extends Migration
{
    private array $permissionData = [
        ['name' => 'access site', 'roles' => ['Access']],
        ['name' => 'view moderation actions', 'roles' => ['Access']],
        ['name' => 'view notes', 'roles' => ['Access']]
    ];

    public function up()
    {
        foreach ($this->permissionData as $data) {
            $permission = Permission::findOrCreate($data['name']);
            foreach ($data['roles'] as $roleName) {
                $role = Role::findByName($roleName);
                $role?->givePermissionTo($data['name']);
            }
        }
    }

    public function down()
    {
        foreach ($this->permissionData as $data) {
            if ($permission = Permission::findByName($data['name'])) {
                foreach ($data['roles'] as $roleName) {
                    $role = Role::findByName($roleName);
                    $role?->revokePermissionTo($data['name']);
                }
                $permission->delete();
            }
        }
    }
}
