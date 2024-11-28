<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->text('title_ar');
            $table->text('title_en');
            $table->text('type');
            $table->text('video_url')->nullable();
            $table->text('questions_number')->nullable();
            $table->text('exam_time')->nullable();
            $table->text('live_url')->nullable();
            $table->text('recorded_url')->nullable();
            $table->text('zoom_time')->nullable();
            $table->text('zoom_duration')->nullable();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('contents')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
}
