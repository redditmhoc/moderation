<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(Str::uuid());

            /** User information */
            $table->string('reddit_username')->index();
            $table->string('discord_username')->nullable();
            $table->bigInteger('discord_id')->nullable();
            $table->string('aliases')->nullable();

            /**
             * Moderator responsible
             */
            $table->foreignUuid('responsible_user_id')->nullable()->constrained('users', 'id')->nullOnDelete();

            /**
             * Content
             */
            $table->longText('content');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
