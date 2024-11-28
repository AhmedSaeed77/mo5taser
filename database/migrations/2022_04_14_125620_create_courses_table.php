<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->text('title_ar');
            $table->text('title_en');
            $table->text('desc_ar');
            $table->text('desc_en');
            $table->float('price');
            $table->float('price_after')->nullable();
            $table->enum('active',[0,1]);
            $table->text('type',[0,1]);
            $table->text('logo');
            $table->text('perview_video');
            $table->text('course_table');
            $table->text('peroid');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
