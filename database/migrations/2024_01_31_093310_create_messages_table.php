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
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('conversations_id')->index('conversation_id');
            $table->unsignedInteger('from_user_id');
            $table->unsignedInteger('to_user_id');
            $table->text('message');
            $table->string('attach_file', 100);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->enum('status', ['new', 'readed'])->default('new');
            $table->enum('remove_from', ['0', '1'])->default('1')->index('remove_from')->comment('0 Delete, 1 Active');
            $table->string('file', 150);
            $table->string('original_name');
            $table->string('format', 10);
            $table->string('size', 50);
            $table->decimal('price', 10);
            $table->enum('tip', ['yes', 'no'])->default('no');
            $table->unsignedInteger('tip_amount');
            $table->enum('mode', ['active', 'pending'])->default('active')->index();

            $table->index(['from_user_id', 'to_user_id', 'status'], 'from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
