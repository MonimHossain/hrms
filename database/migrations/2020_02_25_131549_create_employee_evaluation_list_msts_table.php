<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeEvaluationListMstsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_evaluation_list_msts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('team_id')->unsigned()->comment('From table = Teams');
            $table->bigInteger('employee_id')->unsigned();
            $table->enum('approved_by_employee', ['a', 'r', 'p'])->default('p')->comment('a = Approved, r = Rejected, p = Pending');
            $table->bigInteger('lead_id')->unsigned()->nullable();
            $table->text('lead_remarks')->nullable();
            $table->timestamp('lead_created_at')->nullable();
            $table->bigInteger('evaluation_id')->unsigned()->nullable();
            $table->string('recommendation_for', 350)->nullable();
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('lead_id')->references('id')->on('employees');
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
        Schema::dropIfExists('employee_evaluation_list_msts');
    }
}
