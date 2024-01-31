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
        Schema::create('tax_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 250)->index('name');
            $table->boolean('type')->default(true)->index('type');
            $table->decimal('percentage', 5);
            $table->string('country', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->char('iso_state', 10)->nullable();
            $table->string('stripe_id', 100)->nullable();
            $table->enum('status', ['0', '1'])->default('1');
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
        Schema::dropIfExists('tax_rates');
    }
};
