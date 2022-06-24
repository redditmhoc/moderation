<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOverturnColumnsToBans extends Migration
{
    public function up()
    {
        Schema::table('bans', function (Blueprint $table) {
            $table->boolean('overturned')->default(false);
            $table->foreignUuid('overturned_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('overturned_reason')->nullable();
            $table->dateTime('overturned_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('bans', function (Blueprint $table) {
            $table->dropColumn('overturned', 'overturned_reason', 'overturned_at');
            $table->dropConstrainedForeignId('overturned_by_user_id');
        });
    }
}
