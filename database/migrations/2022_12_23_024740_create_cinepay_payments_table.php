<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinepayPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cinepay_payments', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->timestamps();
            $table->integer("transaction_id",false,20);
            $table->decimal('amount', $precision = 8, $scale = 2);
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cinepay_payments');
    }
}
