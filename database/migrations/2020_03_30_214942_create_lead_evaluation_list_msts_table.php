<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadEvaluationListMstsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_evaluation_list_msts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('team_id')->unsigned()->comment('From table = Teams');
            $table->bigInteger('lead_id')->unsigned()->nullable();
            $table->bigInteger('employee_id')->unsigned();
            $table->text('employee_remarks')->nullable();
            $table->bigInteger('evaluation_id')->unsigned()->nullable();
            $table->json('recommendation_for')->nullable();
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('lead_id')->references('id')->on('employees');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('evaluation_id')->references('id')->on('appraisal_evaluation_names');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_evaluation_list_msts');
    }
}
