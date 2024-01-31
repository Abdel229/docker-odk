<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('messages_id')->index();
            $table->string('type', 100)->index();
            $table->string('file');
            $table->string('width', 5)->nullable();
            $table->string('height', 5)->nullable();
            $table->string('video_poster')->nullable();
            $table->string('file_name');
            $table->string('file_size');
            $table->string('token')->index();
            $table->enum('status', ['active', 'pending'])->default('active');
            $table->timestamps();
            $table->enum('encoded', ['yes', 'no'])->default('no')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_messages');
    }
};
