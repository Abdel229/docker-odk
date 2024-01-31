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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->index();
            $table->integer('product_categories_id')->nullable()->index('product_categories_id');
            $table->string('name');
            $table->char('type', 20)->default('digital');
            $table->decimal('price', 10);
            $table->unsignedInteger('delivery_time');
            $table->integer('product_dim')->nullable();
            $table->integer('product_size')->nullable();
            $table->integer('product_stock')->nullable();
            $table->string('product_delivery_type')->nullable();
            $table->integer('product_promo')->nullable();
            $table->text('tags');
            $table->text('description');
            $table->string('file');
            $table->string('mime', 50)->nullable();
            $table->string('extension', 50)->nullable();
            $table->string('size', 50)->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->boolean('isproduct')->nullable()->default(false);
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
        Schema::dropIfExists('products');
    }
};
