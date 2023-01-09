<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClosingApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closing_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id')->unsigned()->nullable();
            $table->text('application')->nullable();
            $table->timestamp('applied_at');
            $table->tinyInteger('final_closing')->comment('0 = False, 1 = True')->default(0);
            $table->tinyInteger('status')->comment('0 = new, 1 = supervisor_approved, 2 = team_lead_approved, 3 = hr_approved, 4 = rejected')->default(0);
            $table->bigInteger('supervisor_by')->unsigned()->nullable();
            $table->bigInteger('team_lead_by')->unsigned()->nullable();
            $table->bigInteger('hr_by')->unsigned()->nullable();
            $table->bigInteger('rejected_by')->unsigned()->nullable();

            $table->tinyInteger('termination_status')->default(null)->comment('1 = Terminate')->nullable();
            $table->text('termination_remarks')->nullable();
            $table->bigInteger('termination_by')->unsigned()->nullable();
            $table->timestamp('lwd')->default(null);
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('supervisor_by')->references('id')->on('employees');
            $table->foreign('team_lead_by')->references('id')->on('employees');
            $table->foreign('hr_by')->references('id')->on('employees');
            $table->foreign('rejected_by')->references('id')->on('employees');
            $table->foreign('termination_by')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('closing_applications');
    }
}
