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
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('updates_id');
            $table->unsignedInteger('user_id');
            $table->text('reply');
            $table->timestamp('date')->useCurrent();
            $table->enum('status', ['0', '1'])->default('1')->comment('0 Trash, 1 Active');

            $table->index(['updates_id', 'user_id', 'status'], 'post');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
