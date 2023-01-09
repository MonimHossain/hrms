<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeAttendanceSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_attendance_summary', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id');
            $table->string('month', 50);
            $table->integer('present')->default(0);
            $table->integer('holiday')->default(0);
            $table->integer('holiday_present')->default(0);
            $table->integer('half_day')->default(0);
            $table->integer('half_day_present')->default(0);
            $table->integer('weekoff')->default(0);
            $table->integer('adj_day_off')->default(0);
            $table->integer('absent')->default(0);
            $table->integer('lwp')->default(0);
            $table->text('remarks')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = unapproved, 1 = approved');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('employee_attendance_summary');
    }
}
