<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppraisalFilterQuestionListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appraisal_filter_question_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('appraisal_filter_id')->unsigned();
            $table->bigInteger('appraisal_qst_mst_id')->unsigned();

            $table->foreign('appraisal_filter_id')->references('id')->on('appraisal_question_filters');
            $table->foreign('appraisal_qst_mst_id')->references('id')->on('appraisal_qst_msts');

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
        Schema::dropIfExists('appraisal_filter_question_lists');
    }
}
