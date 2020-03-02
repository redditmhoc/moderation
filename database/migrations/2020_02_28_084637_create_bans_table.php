<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reddit_username');
            $table->bigInteger('discord_user_id')->nullable();
            $table->integer('strike_level')->nullable();
            $table->dateTime('start_timestamp');
            $table->dateTime('end_timestamp')->nullable();
            $table->integer('probation_length')->nullable();
            $table->unsignedInteger('moderator_id');
            $table->foreign('moderator_id')->references('id')->on('users');
            $table->text('reason')->nullable();
            $table->longText('comments')->nullable();
            $table->text('evidence')->nullable();
            $table->boolean('auto_discord_ban')->default(false);
            $table->boolean('subreddit_ban')->default(false);
            $table->boolean('overturned')->default(false);
            $table->dateTime('overturned_timestamp')->nullable();
            $table->longText('overturned_comments')->nullable();
            $table->unsignedInteger('overturned_moderator_id')->nullable();
            $table->foreign('overturned_moderator_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bans');
    }
}
