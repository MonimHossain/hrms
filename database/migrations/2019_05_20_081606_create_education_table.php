<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id')->unsigned();
            $table->bigInteger('level_of_education_id')->unsigned()->nullable();
            //$table->bigInteger('institute_id')->unsigned()->nullable();
            $table->string('institute')->nullable();

            $table->string('exam_degree_title')->nullable();
            $table->string('major')->nullable();
            $table->string('result')->nullable();
            $table->string('passing_year')->nullable();
            $table->string('edu_file')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('level_of_education_id')->references('id')->on('level_of_education')->onDelete('cascade');
            //$table->foreign('institute_id')->references('id')->on('institutes')->onDelete('cascade');

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
        Schema::dropIfExists('education');
    }
}
