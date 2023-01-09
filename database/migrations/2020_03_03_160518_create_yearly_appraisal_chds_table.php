<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearlyAppraisalChdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yearly_appraisal_chds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('y_a_mst_id')->unsigned();
            $table->bigInteger('employee_id')->unsigned();
            $table->decimal('score', 8, 2)->nullable();
            $table->json('recommendation_for')->nullable();
            $table->text('comments')->nullable();
            $table->bigInteger('recommendation_by')->unsigned()->nullable();
            $table->bigInteger('approved_by')->unsigned()->nullable();
            $table->enum('approved_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('approval_comments')->nullable();
            $table->timestamps();

            $table->foreign('y_a_mst_id')->references('id')->on('yearly_appraisal_msts');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('recommendation_by')->references('id')->on('employees');
            $table->foreign('approved_by')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yearly_appraisal_chds');
    }
}
