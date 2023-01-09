<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppraisalQuestionFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appraisal_question_filters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('question_type', ['employee', 'lead', 'company'])->nullable();
            $table->bigInteger('division_id')->unsigned()->nullable();
            $table->bigInteger('center_id')->unsigned()->nullable();
            $table->tinyInteger('department_id')->unsigned()->nullable();
            $table->tinyInteger('process_id')->unsigned()->nullable();
            $table->tinyInteger('process_segment_id')->unsigned()->nullable();
            $table->bigInteger('name')->unsigned();

            $table->foreign('name')->references('id')->on('appraisal_evaluation_names');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');

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
        Schema::dropIfExists('appraisal_question_filters');
    }
}
