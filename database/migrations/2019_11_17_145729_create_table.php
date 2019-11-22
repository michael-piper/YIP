<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE api_tokens AUTO_INCREMENT=500000000000;");
        DB::statement("ALTER TABLE carts AUTO_INCREMENT=300000000000;");
        DB::statement("ALTER TABLE orders AUTO_INCREMENT=800000000000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
