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
        Schema::create('deposits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('txn_id', 200);
            $table->unsignedInteger('amount');
            $table->string('payment_gateway', 100);
            $table->timestamp('date')->useCurrentOnUpdate()->useCurrent();
            $table->enum('status', ['active', 'pending'])->default('active');
            $table->string('screenshot_transfer', 100);
            $table->string('percentage_applied', 50);
            $table->double('transaction_fee', 10, 2);
            $table->text('taxes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposits');
    }
};
