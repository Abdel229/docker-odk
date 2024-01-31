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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('type');
            $table->enum('enabled', ['1', '0'])->default('1');
            $table->enum('sandbox', ['true', 'false'])->default('true');
            $table->decimal('fee', 3, 1);
            $table->decimal('fee_cents', 3);
            $table->string('email', 80);
            $table->string('token', 200);
            $table->string('key');
            $table->string('key_secret');
            $table->text('bank_info');
            $table->enum('recurrent', ['yes', 'no']);
            $table->string('logo', 50);
            $table->string('webhook_secret');
            $table->enum('subscription', ['yes', 'no'])->default('yes');
            $table->string('ccbill_accnum', 200);
            $table->string('ccbill_subacc', 200);
            $table->string('ccbill_flexid', 200);
            $table->string('ccbill_salt', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_gateways');
    }
};
