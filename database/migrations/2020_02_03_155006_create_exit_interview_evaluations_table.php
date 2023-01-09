<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExitInterviewEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exit_interview_evaluations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id')->unsigned();
            $table->bigInteger('application_id')->unsigned();
            $table->bigInteger('lead_id')->unsigned();
            $table->bigInteger('qst_no')->unsigned();
            $table->string('qst_name', 150);
            $table->string('ans_label', 50);
            $table->text('ans_text')->nullable();
            $table->string('ans_value', 3)->nullable();
            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('closing_applications');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('lead_id')->references('id')->on('employees');
            $table->foreign('qst_no')->references('id')->on('interview_qst_msts');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exit_interview_evaluations');
    }
}
