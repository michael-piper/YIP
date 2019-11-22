<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('product_id')->nullable(false);
            $table->string('tracking_id',22)->nullable(false);
            $table->unsignedBigInteger('quantity')->nullable(false)->default(0);
            $table->json('contact')->nullable(false);
            $table->unsignedBigInteger('order_status')->default(0);
            $table->unsignedBigInteger('payment_status')->default(0);
            $table->boolean('active')->nullable(false)->default(true);

            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('order_status')->references('id')->on('order_status');
            $table->foreign('payment_status')->references('id')->on('payment_status');
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
}
