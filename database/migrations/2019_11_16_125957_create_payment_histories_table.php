<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sender_id')->nullable(false);
            $table->unsignedBigInteger('receiver_id')->nullable(false);
            $table->unsignedBigInteger('amount')->nullable(false);
            $table->unsignedBigInteger('commission')->nullable(false);
            $table->text('comment');
            $table->tinyInteger('type')->nullable(false)->default(1);
            $table->string('display_type',100)->nullable(false)->default("Withdrawal");
            $table->foreign('sender_id')->references('id')->on('users')->onDelete("cascade");
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete("cascade");
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
        Schema::dropIfExists('payment_histories');
    }
}
