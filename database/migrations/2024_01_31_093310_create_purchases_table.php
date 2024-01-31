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
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('transactions_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('products_id')->index();
            $table->string('delivery_status', 50)->default('delivered');
            $table->longText('description_custom_content')->nullable();
            $table->integer('phone_number')->nullable();
            $table->string('city')->nullable();
            $table->string('delivery_type')->nullable();
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
        Schema::dropIfExists('purchases');
    }
};
