<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',100)->nullable(false);
            $table->string('description',255)->nullable(true);
            $table->boolean('active')->nullable(false)->default(true);
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
        Schema::dropIfExists('product_status');
    }
}
