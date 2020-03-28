<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'access']);
        Permission::create(['name' => 'view actions']);
        Permission::create(['name' => 'create ban']);
        Permission::create(['name' => 'edit ban']);
        Permission::create(['name' => 'overturn ban']);
        Permission::create(['name' => 'subreddit ban']);
        Permission::create(['name' => 'issue permanent ban']);
        Permission::create(['name' => 'create warning']);
        Permission::create(['name' => 'edit warning']);
        Permission::create(['name' => 'overturn warning']);

        // create admin role (can do anything, so quad and guardians)
        $adminRole = Role::create(['name' => 'admin']);

        // create speakership role (can do most things)
        $speakershipRole = Role::create(['name' => 'speakership']);
        $speakershipRole->givePermissionTo('access');
        $speakershipRole->givePermissionTo('view actions');
        $speakershipRole->givePermissionTo('create ban');
        $speakershipRole->givePermissionTo('edit ban');
        $speakershipRole->givePermissionTo('create warning');
        $speakershipRole->givePermissionTo('edit warning');

        // create adviser role (can view things)
        $adviserRole = Role::create(['name' => 'adviser']);
        $adviserRole->givePermissionTo('access');
        $adviserRole->givePermissionTo('view actions');
    }
}
