<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_balances', function (Blueprint $table) {
//            $table->bigIncrements('id');
//            $table->bigInteger('employee_id');
//            $table->string('year');
//            $table->decimal('total_casual_leave', 3, 1);
//            $table->decimal('remain_casual_leave', 3, 1)->nullable();
//            $table->decimal('taken_casual_leave', 3, 1)->nullable();
//            $table->decimal('total_sick_leave', 3, 1);
//            $table->decimal('remain_sick_leave', 3, 1)->nullable();
//            $table->decimal('taken_sick_leave', 3, 1)->nullable();
//            $table->decimal('total_earned_leave', 3, 1);
//            $table->decimal('remain_earned_leave', 3, 1)->nullable();
//            $table->decimal('taken_earned_leave', 3, 1)->nullable();
//            $table->decimal('total_maternity_leave', 4, 1);
//            $table->decimal('remain_maternity_leave', 4, 1)->nullable();
//            $table->decimal('taken_maternity_leave', 4, 1)->nullable();
//            $table->decimal('total_paternity_leave', 3, 1);
//            $table->decimal('remain_paternity_leave', 3, 1)->nullable();
//            $table->decimal('taken_paternity_leave', 3, 1)->nullable();
//            $table->decimal('total_lwp_leave', 3, 1);
//            $table->decimal('taken_lwp_leave', 3, 1)->nullable();
//            $table->decimal('remain_lwp_leave', 3, 1)->nullable();
//            $table->dateTime('probation_start_date')->nullable();
//            $table->dateTime('permanent_doj')->nullable();
//            $table->smallInteger('employee_type');
//            $table->timestamps();

            $table->bigIncrements('id');
            $table->bigInteger('employee_id')->unsigned();
            $table->string('year');
            $table->date('probation_start_date')->nullable();
            $table->date('permanent_doj')->nullable();
            $table->bigInteger('employment_type_id')->unsigned()->nullable();
            $table->bigInteger('leave_type_id')->unsigned()->nullable();
            $table->decimal('total', 4, 1)->default(0);
            $table->decimal('used', 4, 1)->default(0);
            $table->decimal('remain', 4, 1)->default(0);
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('employment_type_id')->references('id')->on('employment_types')->onDelete('restrict');
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_balances');
    }
}
