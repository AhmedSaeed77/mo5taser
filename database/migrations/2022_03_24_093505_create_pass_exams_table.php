<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pass_exams', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->integer('questions_number');
            $table->integer('exam_time')->nullable();
            $table->integer('attemps');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('main_cat');
            $table->unsignedBigInteger('level');
            $table->timestamps();
            $table->foreign('teacher_id')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('main_cat')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('level')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pass_exams');
    }
}
