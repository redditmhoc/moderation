<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMutesTable extends Migration
{
    public function up()
    {
        Schema::create('mutes', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(Str::uuid());

            /** User information */
            $table->string('reddit_username')->index();
            $table->string('discord_username')->nullable();
            $table->bigInteger('discord_id')->nullable();
            $table->string('aliases')->nullable();

            /**
             * Dates
             */
            $table->dateTime('start_at');
            $table->dateTime('end_at');

            /**
             * Moderator responsible
             */
            $table->foreignUuid('responsible_user_id')->nullable()->constrained('users', 'id')->nullOnDelete();

            /**
             * Reasoning
             */
            $table->text('summary')->nullable();
            $table->longText('comments')->nullable();
            $table->longText('evidence')->nullable();

            /**
             * Details
             */
            $table->enum('platforms', ['REDDIT', 'DISCORD', 'BOTH'])->default('BOTH');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mutes');
    }
}
