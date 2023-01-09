<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearlyAppraisalMstsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yearly_appraisal_msts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('dept_id')->unsigned()->comment('From center_department table');
            $table->year('year');
            $table->enum('status', ['regenerate', 'generate'])->default('generate');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('dept_id')->references('id')->on('center_department');
            $table->foreign('created_by')->references('id')->on('employees');
            $table->foreign('updated_by')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yearly_appraisal_msts');
    }
}
