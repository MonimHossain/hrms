<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClosingClearanceStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closing_clearance_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('closing_applications_id')->unsigned();

            $table->text('hr_clearance')->nullable();
            $table->json('hr_checklist')->nullable();
            $table->tinyInteger('hr_status')->default(0)->comment('0 = Pending, 1 = Approved, 2 = Rejected');
            $table->bigInteger('hr_hod_by')->unsigned()->nullable();
            $table->bigInteger('hr_in_charge_by')->unsigned()->nullable();

            $table->text('it_clearance')->nullable();
            $table->json('it_checklist')->nullable();
            $table->tinyInteger('it_status')->default(0)->comment('0 = Pending, 1 = Approved, 2 = Rejected');
            $table->bigInteger('it_hod_by')->unsigned()->nullable();
            $table->bigInteger('it_in_charge_by')->unsigned()->nullable();

            $table->text('admin_clearance')->nullable();
            $table->json('admin_checklist')->nullable();
            $table->tinyInteger('admin_status')->default(0)->comment('0 = Pending, 1 = Approved, 2 = Rejected');
            $table->bigInteger('admin_hod_by')->unsigned()->nullable();
            $table->bigInteger('admin_in_charge_by')->unsigned()->nullable();

            $table->text('accounts_clearance')->nullable();
            $table->json('accounts_checklist')->nullable();
            $table->tinyInteger('accounts_status')->default(0)->comment('0 = Pending, 1 = Approved, 2 = Rejected');
            $table->bigInteger('accounts_hod_by')->unsigned()->nullable();
            $table->bigInteger('accounts_in_charge_by')->unsigned()->nullable();

            $table->text('own_dept_clearance')->nullable();
            $table->json('own_dept_checklist')->nullable();
            $table->tinyInteger('own_dept_status')->default(0)->comment('0 = Pending, 1 = Approved, 2 = Rejected');
            $table->bigInteger('own_dept_hod_by')->unsigned()->nullable();
            $table->bigInteger('own_dept_in_charge_by')->unsigned()->nullable();

            $table->timestamps();

            $table->foreign('closing_applications_id')->references('id')->on('closing_applications');

            $table->foreign('hr_hod_by')->references('id')->on('employees');
            $table->foreign('hr_in_charge_by')->references('id')->on('employees');

            $table->foreign('it_hod_by')->references('id')->on('employees');
            $table->foreign('it_in_charge_by')->references('id')->on('employees');

            $table->foreign('admin_hod_by')->references('id')->on('employees');
            $table->foreign('admin_in_charge_by')->references('id')->on('employees');

            $table->foreign('accounts_hod_by')->references('id')->on('employees');
            $table->foreign('accounts_in_charge_by')->references('id')->on('employees');

            $table->foreign('own_dept_hod_by')->references('id')->on('employees');
            $table->foreign('own_dept_in_charge_by')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('closing_clearance_statuses');
    }
}
