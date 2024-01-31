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
        Schema::create('front_setting', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->text('slider_title')->nullable();
            $table->text('slider_description')->nullable();
            $table->text('earning_title')->nullable();
            $table->text('earning_description')->nullable();
            $table->text('earning_title1')->nullable();
            $table->text('earning_description1')->nullable();
            $table->text('earning_title2')->nullable();
            $table->text('earning_description2')->nullable();
            $table->text('earning_title3')->nullable();
            $table->text('earning_description3')->nullable();
            $table->text('profile_title')->nullable();
            $table->text('profile_description')->nullable();
            $table->text('creators_title')->nullable();
            $table->text('creators_description')->nullable();
            $table->text('creators_earning_title')->nullable();
            $table->text('creators_earning_description')->nullable();
            $table->text('creators_earning_title1')->nullable();
            $table->text('creators_earning_description1')->nullable();
            $table->text('waiting_title')->nullable();
            $table->text('waiting_description')->nullable();
            $table->text('number_followers_title')->nullable();
            $table->integer('monthly_subscription_price');
            $table->text('monthly_subscription_title')->nullable();
            $table->integer('min_subscription_amount')->nullable();
            $table->integer('min_number_followers')->nullable();
            $table->integer('max_number_followers')->nullable();
            $table->integer('max_subscription_amount')->nullable();
            $table->text('earnings_simulator_subtitle_2')->nullable();
            $table->text('per_month')->nullable();
            $table->text('earnings_simulator_subtitle_4')->nullable();
            $table->text('earnings_simulator_subtitle_5')->nullable();
            $table->text('earnings_simulator_subtitle_6')->nullable();
            $table->text('earnings_simulator_subtitle_7')->nullable();
            $table->text('earnings_simulator_subtitle_8')->nullable();
            $table->text('earnings_simulator_subtitle_9')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('front_setting');
    }
};
