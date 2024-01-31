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
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('txn_id', 250);
            $table->unsignedInteger('user_id')->index('user_id');
            $table->unsignedInteger('subscriptions_id')->index('subscriber');
            $table->unsignedInteger('subscribed')->index('subscribed');
            $table->timestamp('created_at')->useCurrent();
            $table->decimal('earning_net_user', 10);
            $table->decimal('earning_net_admin', 10);
            $table->string('payment_gateway', 100);
            $table->enum('approved', ['0', '1', '2'])->default('1')->comment('0 Pending, 1 Success, 2 Canceled');
            $table->float('amount', 10, 0);
            $table->string('type', 100)->default('subscription');
            $table->string('percentage_applied', 50);
            $table->unsignedInteger('referred_commission');
            $table->text('taxes')->nullable();
            $table->boolean('direct_payment')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
