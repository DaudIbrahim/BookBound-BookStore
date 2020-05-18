<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {

            // Keys
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subcategory_id');
            $table->unsignedBigInteger('author_id');

            // About Book
            $table->string('title')->unique();
            $table->string('isbn_10', 20);
            $table->string('isbn_13', 20);
            $table->string('image', 2500);
            $table->string('published_date', 20);
            $table->string('description', 2500);
            $table->string('page_count', 20);
            $table->string('lang', 20);
            $table->string('publisher', 255);

            // Price & Quantity
            $table->unsignedInteger('new_price');
            $table->unsignedInteger('new_quantity');
            $table->unsignedInteger('used_price');
            $table->unsignedInteger('used_quantity');
            $table->timestamps();

            // FK References
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('author_id')->references('id')->on('authors')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
