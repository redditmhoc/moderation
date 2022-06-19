<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRecordWritePermissions extends Migration
{
    private array $permissionData = [
        ['name' => 'create mutes', 'roles' => ['Moderator', 'Quadrumvirate']],
        ['name' => 'create bans', 'roles' => ['Moderator', 'Quadrumvirate']],
        ['name' => 'create permanent bans', 'roles' => ['Quadrumvirate']],
        ['name' => 'create notes', 'roles' => ['Moderator', 'Quadrumvirate']],
        ['name' => 'edit all mutes', 'roles' => ['Moderator', 'Quadrumvirate']],
        ['name' => 'edit all bans', 'roles' => ['Quadrumvirate']],
        ['name' => 'edit all notes', 'roles' => ['Quadrumvirate']],
        ['name' => 'delete all mutes', 'roles' => ['Moderator', 'Quadrumvirate']],
        ['name' => 'delete all bans', 'roles' => ['Quadrumvirate']],
        ['name' => 'delete all notes', 'roles' => ['Quadrumvirate']],
        ['name' => 'overturn mutes', 'roles' => ['Moderator', 'Quadrumvirate']],
        ['name' => 'overturn bans', 'roles' => ['Quadrumvirate']],
        ['name' => 'overturn permanent bans', 'roles' => ['Quadrumvirate']],
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
