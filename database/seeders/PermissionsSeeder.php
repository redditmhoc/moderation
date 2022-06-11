<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeders.
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
        Permission::create(['name' => 'commons tasks']);
        Permission::create(['name' => 'lords tasks']);
        Permission::create(['name' => 'holyrood tasks']);
        Permission::create(['name' => 'stormont tasks']);
        Permission::create(['name' => 'senedd tasks']);


        // create admin role (can do anything, so quad and guardians)
        $adminRole = Role::create(['name' => 'Admin', 'colour' => '#6EEB83']);

        // create discord mod role (can do most things)
        $speakershipRole = Role::create(['name' => 'Discord Moderator', 'colour' => '#71B340']);
        $speakershipRole->givePermissionTo('access');
        $speakershipRole->givePermissionTo('view actions');
        $speakershipRole->givePermissionTo('create ban');
        $speakershipRole->givePermissionTo('edit ban');
        $speakershipRole->givePermissionTo('create warning');
        $speakershipRole->givePermissionTo('edit warning');

        // create adviser role (can view things)
        $adviserRole = Role::create(['name' => 'Adviser', 'colour' => '#FF8421']);
        $adviserRole->givePermissionTo('access');
        $adviserRole->givePermissionTo('view actions');

        // create commons speakership role
        $commonsSpeakershipRole = Role::create(['name' => 'Commons Speakership', 'colour' => '#006B3E']);
        $commonsSpeakershipRole->givePermissionTo('access');
        $commonsSpeakershipRole->givePermissionTo('commons tasks');

        // create lords speakership role
        $lordsSpeakershipRole = Role::create(['name' => 'Lords Speakership', 'colour' => 'rgb(237, 41, 57)']);
        $lordsSpeakershipRole->givePermissionTo('access');
        $lordsSpeakershipRole->givePermissionTo('lords tasks');

        // create holyrood speakership role
        $holyroodSpeakershipRole = Role::create(['name' => 'Holyrood Speakership', 'colour' => '#5B3082']);
        $holyroodSpeakershipRole->givePermissionTo('access');
        $holyroodSpeakershipRole->givePermissionTo('holyrood tasks');

        // create stormont speakership role
        $stormontSpeakershipRole = Role::create(['name' => 'Stormont Speakership', 'colour' => '#6699cc']);
        $stormontSpeakershipRole->givePermissionTo('access');
        $stormontSpeakershipRole->givePermissionTo('stormont tasks');

        // create senedd speakership role
        $seneddSpeakershipRole = Role::create(['name' => 'Senedd Speakership', 'colour' => '#950754']);
        $seneddSpeakershipRole->givePermissionTo('access');
        $seneddSpeakershipRole->givePermissionTo('senedd tasks');
    }
}
