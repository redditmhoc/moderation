<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('bans', function (Blueprint $table) {
            $table->boolean('expiry_reminder_sent')->default(false);
            $table->dateTime('expiry_reminder_sent_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('bans', function (Blueprint $table) {
            $table->dropColumn(['expiry_reminder_sent', 'expiry_reminder_sent_at']);
        });
    }
};
