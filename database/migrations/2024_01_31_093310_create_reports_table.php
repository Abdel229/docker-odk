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
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('report_id');
            $table->enum('type', ['user', 'update']);
            $table->enum('reason', ['copyright', 'privacy_issue', 'violent_sexual', 'spoofing', 'spam', 'fraud', 'under_age']);
            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'report_id'], 'user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
