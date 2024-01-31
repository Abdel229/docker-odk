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
        Schema::create('cinepay_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('transaction_id');
            $table->integer('id_subscribe')->nullable();
            $table->integer('id_product')->nullable();
            $table->decimal('amount');
            $table->string('delivery_status')->nullable();
            $table->text('description_custom_content')->nullable();
            $table->string('plan_interval')->nullable();
            $table->integer('type_operation')->comment('elle defini le type d\'opération ayant conduit à une demande de payement.
1. Pour dévérouller un poste, 
2. Pour une souscription,
3. pour recharger le wallet.
4.pour un achat de produit
5.Pourboire');
            $table->string('origin_url')->nullable();
            $table->integer('id_update')->nullable();
            $table->unsignedBigInteger('user_id');
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
};
