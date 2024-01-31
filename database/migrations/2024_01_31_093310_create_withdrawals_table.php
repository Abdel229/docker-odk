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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index('campaings_id');
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->string('amount', 50);
            $table->timestamp('date')->useCurrent();
            $table->string('gateway', 100);
            $table->text('account');
            $table->timestamp('date_paid')->default('0000-00-00 00:00:00');
            $table->string('txn_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdrawals');
    }
};
