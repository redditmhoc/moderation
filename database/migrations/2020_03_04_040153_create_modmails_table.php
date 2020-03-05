<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modmails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject')->nullable();
            $table->longText('content');
            $table->dateTime('timestamp');
            $table->bigInteger('recipient_id');
            $table->foreign('recipient_id')->references('id')->on('roles');
            $table->boolean('archived')->default(false);
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
        Schema::dropIfExists('modmails');
    }
}
