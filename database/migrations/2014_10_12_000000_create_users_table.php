<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('display_name',200);
            $table->string('display_image',255)->nullable(true);
            $table->string('email',100)->unique();
            $table->string('phone',30)->unique();
            $table->string('password');
            $table->string('display_type',25)->nullable(false)->default("Customer");
            $table->tinyInteger('type')->nullable(false)->default(1);
            $table->tinyInteger('status')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('api_token',100)->default(null);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
