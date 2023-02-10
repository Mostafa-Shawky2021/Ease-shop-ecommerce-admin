<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->nullable();
            $table->string('username');
            $table->string('phone');
            $table->string('governorate');
            $table->string('street');
            $table->string('email')->nullable();
            $table->string('order_notes')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedSmallInteger('total_price');
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
        Schema::dropIfExists('orders');
    }
};