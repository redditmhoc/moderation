<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteToBans extends Migration
{
    public function up()
    {
        Schema::table('bans', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('bans', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
