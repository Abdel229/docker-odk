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
        Schema::create('verification_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index('user_id');
            $table->string('address', 200);
            $table->string('city', 150);
            $table->string('zip', 50);
            $table->string('image', 100);
            $table->enum('status', ['pending', 'approved'])->default('pending');
            $table->timestamp('created_at')->useCurrent();
            $table->string('form_w9', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verification_requests');
    }
};
