<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            
            // PK
            $table->bigIncrements('id');

            // FK
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id');

            // Description | Rating | Timestamps
            $table->string('description', 100);
            $table->unsignedTinyInteger('rating');
            $table->timestamps();

            // FK References
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('book_id')->references('id')->on('books')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
