<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHourlySalaryHistoryBreakdownTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hourly_salary_history_breakdown', function (Blueprint $table) {
            // $table->bigIncrements('id');
            // $table->bigInteger('employee_id')->unsigned();
            // $table->bigInteger('salary_history_id')->unsigned();
            // $table->decimal('rate', 8, 2);
            // $table->decimal('ready_hour', 5, 2);
            // $table->decimal('lag_hour', 5, 2)->nullable();
            // $table->decimal('break_hour', 5, 2)->nullable();
            // $table->decimal('ot_hour', 5, 2)->nullable();
            // $table->decimal('kpi_amout', 5, 2)->nullable();
            // $table->string('kpi_grade')->nullable();
            // $table->bigInteger('created_by')->nullable();
            // $table->bigInteger('updated_by')->nullable();
            
            // $table->timestamps();
            // $table->foreign('created_by')->references('id')->on('employees');
            // $table->foreign('updated_by')->references('id')->on('employees');
            // $table->foreign('salary_history_id')->references('id')->on('salary_history')->onDelete('cascade');            
            // $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hourly_salary_history_breakdown', function (Blueprint $table) {

        });
    }
}
