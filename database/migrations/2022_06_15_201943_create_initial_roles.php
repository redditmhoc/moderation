<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

class CreateInitialRoles extends Migration
{
    private array $roleNames = [
        'Administrator',
        'Quadrumvirate',
        'Moderator',
        'Advisor',
        'Access',
        'Member'
    ];

    public function up()
    {
        foreach ($this->roleNames as $name) {
            Role::findOrCreate($name);
        }
    }

    public function down()
    {
        foreach ($this->roleNames as $name) {
            if ($role = Role::findByName($name)) {
                $role->delete();
            }
        }
    }
}
