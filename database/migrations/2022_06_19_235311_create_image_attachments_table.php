<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageAttachmentsTable extends Migration
{
    public function up()
    {
        Schema::create('image_attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('url');
            $table->foreignUuid('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('caption')->nullable();
            $table->uuidMorphs('attachable');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('image_attachments');
    }
}
