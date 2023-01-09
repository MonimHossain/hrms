<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeJourneyArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_journey_archives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id')->unsigned();
            $table->string('employer_id')->unique()->nullable();
            //$table->bigInteger('process_id')->unsigned()->nullable();
            //$table->bigInteger('process_segment_id')->unsigned()->nullable();
            $table->bigInteger('designation_id')->unsigned()->nullable();
            $table->bigInteger('job_role_id')->unsigned()->nullable();
            //$table->bigInteger('department_id')->unsigned()->nullable();
            $table->bigInteger('employment_type_id')->unsigned()->nullable();
            $table->bigInteger('employee_status_id')->unsigned()->nullable();
            //$table->bigInteger('sup1')->unsigned()->nullable();
            //$table->bigInteger('sup2')->unsigned()->nullable();
            //$table->bigInteger('hod')->unsigned()->nullable();
            $table->date('doj')->nullable();
            $table->date('lwd')->nullable();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            //$table->date('process_doj')->nullable();
            //$table->date('process_lwd')->nullable();
            $table->date('probation_start_date')->nullable();
            $table->integer('probation_period')->nullable();
            $table->text('probation_remarks')->nullable();
            $table->date('permanent_doj')->nullable();
            $table->date('new_role_doj')->nullable();
            $table->boolean('is_fixed_officetime')->default(0);
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            //$table->foreign('process_id')->references('id')->on('processes')->onDelete('cascade');
            //$table->foreign('process_segment_id')->references('id')->on('process_segments')->onDelete('cascade');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
            $table->foreign('job_role_id')->references('id')->on('job_roles')->onDelete('cascade');
            //$table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('employment_type_id')->references('id')->on('employment_types')->onDelete('cascade');
            $table->foreign('employee_status_id')->references('id')->on('employee_statuses')->onDelete('cascade');
            //$table->foreign('sup1')->references('id')->on('employees')->onDelete('cascade');
            //$table->foreign('sup2')->references('id')->on('employees')->onDelete('cascade');
            //$table->foreign('hod')->references('id')->on('employees')->onDelete('cascade');

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
        Schema::dropIfExists('employee_journey_archives');
    }
}
