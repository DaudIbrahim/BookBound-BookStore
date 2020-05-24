<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('code')->unique();

            /**
             * The unsigned range of a small integer is 0 to 65535.
             * ReferenceWeb - https://mariadb.com/kb/en/smallint/
             */
            $table->unsignedSmallInteger('percent');
            $table->unsignedSmallInteger('quantity');
            
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
        Schema::dropIfExists('coupons');
    }
}
