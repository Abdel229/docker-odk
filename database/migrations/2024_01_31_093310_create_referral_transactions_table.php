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
        Schema::create('referral_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('transactions_id')->nullable()->index();
            $table->unsignedInteger('referrals_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('referred_by')->index();
            $table->double('earnings', 10, 2);
            $table->char('type', 25);
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
        Schema::dropIfExists('referral_transactions');
    }
};
