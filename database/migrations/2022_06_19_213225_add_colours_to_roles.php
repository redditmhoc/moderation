<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class AddColoursToRoles extends Migration
{
    private array $roleData = [
        ['Administrator', '#d81e5b'],
        ['Quadrumvirate', '#62cf73'],
        ['Moderator', '#71b340'],
        ['Advisor', '#ff8421'],
        ['Access', '#71368a'],
        ['Member', null]
    ];

    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('colour_hex')->nullable();
        });

        foreach ($this->roleData as $array) {
            $role = Role::findByName($array[0]);
            $role->colour_hex = $array[1];
            $role->save();
        }
    }

    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('colour_hex');
        });
    }
}
