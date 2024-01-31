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
        Schema::create('updates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('image')->index('image');
            $table->string('video', 100)->index('video');
            $table->text('description');
            $table->unsignedInteger('user_id')->index('category_id');
            $table->timestamp('date')->useCurrent();
            $table->string('token_id')->unique('token_id');
            $table->enum('locked', ['yes', 'no'])->default('no');
            $table->string('music', 200);
            $table->string('file', 200);
            $table->string('img_type', 5);
            $table->enum('fixed_post', ['0', '1'])->default('0');
            $table->decimal('price', 10);
            $table->string('video_embed', 200);
            $table->string('file_name');
            $table->string('file_size', 50);
            $table->char('status', 20)->default('active')->index();

            $table->index(['token_id'], 'author_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('updates');
    }
};
