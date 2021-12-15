<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderCheckersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_checkers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checker_id');
            $table->unsignedBigInteger('translator_id');
            $table->unsignedBigInteger('order_id');
            $table->longText('comment')->nullable();
            $table->char('status');
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
        Schema::dropIfExists('order_checkers');
    }
}
