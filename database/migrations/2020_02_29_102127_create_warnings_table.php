<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warnings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reddit_username');
            $table->bigInteger('discord_user_id')->nullable();
            $table->dateTime('timestamp');
            $table->integer('muted_minutes')->default(0);
            $table->unsignedInteger('moderator_id');
            $table->foreign('moderator_id')->references('id')->on('users');
            $table->text('reason')->nullable();
            $table->longText('comments')->nullable();
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
        Schema::dropIfExists('warnings');
    }
}
