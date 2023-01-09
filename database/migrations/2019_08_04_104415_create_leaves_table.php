<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id')->unsigned();
            $table->string('subject');
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->bigInteger('leave_type_id')->unsigned()->nullable();
            $table->integer('half_day')->nullable();
            $table->string('leave_location');
            $table->date('resume_date');
            $table->decimal('quantity', 10, 1);
            $table->integer('leave_status')->default(0);
            $table->text('leave_days')->nullable();
            $table->boolean('from_forwarded_el')->default('0');
            $table->bigInteger('leave_rule_id')->unsigned()->nullable();
            $table->bigInteger('supervisor_approved_by')->unsigned()->nullable();
            $table->bigInteger('hot_approved_by')->unsigned()->nullable();
            $table->bigInteger('rejected_by')->unsigned()->nullable();
            $table->boolean('cancel_request')->default(0);
            $table->bigInteger('cancelled_by')->unsigned()->nullable();
            $table->text('remarks')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('set null');
            $table->foreign('leave_rule_id')->references('id')->on('leave_rules')->onDelete('set null');
            $table->foreign('supervisor_approved_by')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('hot_approved_by')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('rejected_by')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('cancelled_by')->references('id')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaves');
    }
}
