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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('stripe_id');
            $table->string('stripe_status');
            $table->string('stripe_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->string('last_payment')->nullable()->index('last_payment');
            $table->enum('free', ['yes', 'no'])->default('no');
            $table->string('subscription_id', 50);
            $table->enum('cancelled', ['yes', 'no'])->default('no');
            $table->enum('rebill_wallet', ['on', 'off'])->default('off');
            $table->string('interval', 100)->default('monthly');
            $table->text('taxes')->nullable();

            $table->index(['user_id', 'stripe_status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};
