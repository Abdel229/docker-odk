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
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('destination');
            $table->unsignedInteger('author');
            $table->unsignedInteger('target');
            $table->unsignedInteger('type')->comment('1 Subscribed, 2  Like, 3 reply, 4 Like Comment');
            $table->enum('status', ['0', '1'])->default('0')->comment('0 unseen, 1 seen');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['destination', 'author', 'target', 'status'], 'destination');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
