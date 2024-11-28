<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assembles', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->text('title_ar');
            $table->text('title_en');
            $table->text('content_ar');
            $table->text('content_en');
            $table->enum('type',['book','video']);
            $table->text('image');
            $table->text('link')->nullable();
            $table->float('price')->nullable();
            $table->text('book_preview')->nullable();
            $table->text('book')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('assembles');
    }
}
