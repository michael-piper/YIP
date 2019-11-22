<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('category_id')->nullable(false);
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->string('name',255)->nullable(false);
            $table->string('display_image',255)->nullable(true);
            $table->unsignedBigInteger('price')->nullable(false)->default(0);
            $table->bigInteger('commission')->nullable(false)->default(0);
            $table->integer('available')->nullable(false)->default(0);
            $table->integer('sold')->nullable(false)->default(0);
            $table->string('year',255)->nullable(false);
            $table->string('make',100)->nullable(false);
            $table->string('model',100)->nullable(true);
            $table->boolean('oem')->nullable(false)->default(false);
            $table->string('part_number',100)->nullable(true);
            $table->unsignedBigInteger('condition')->nullable(false);
            $table->text('description')->nullable(true);
            $table->jsonb('addons')->nullable(true);
            $table->boolean('active')->nullable(false)->default(true);

            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");
            $table->foreign('category_id')->references('id')->on('product_categories');
            $table->foreign('sub_category_id')->references('id')->on('product_sub_categories');
            $table->foreign('condition')->references('id')->on('product_status');
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
        Schema::dropIfExists('products');
    }
}
