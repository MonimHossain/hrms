<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClosingClearanceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closing_clearance_settings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('hr_hod_id')->unsigned()->nullable();
            $table->bigInteger('hr_in_charge_id')->unsigned()->nullable();
            $table->text('hr_clearance_template')->nullable();

            $table->bigInteger('it_hod_id')->unsigned()->nullable();
            $table->bigInteger('it_in_charge_id')->unsigned()->nullable();
            $table->text('it_clearance_template')->nullable();

            $table->bigInteger('admin_hod_id')->unsigned()->nullable();
            $table->bigInteger('admin_in_charge_id')->unsigned()->nullable();
            $table->text('admin_clearance_template')->nullable();

            $table->bigInteger('accounts_hod_id')->unsigned()->nullable();
            $table->bigInteger('accounts_in_charge_id')->unsigned()->nullable();
            $table->text('accounts_clearance_template')->nullable();

            $table->text('default_clearance_template');
            $table->text('clearance_application_template');

            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();

            $table->timestamps();

            /*$table->unique(['hr_hod_id', 'hr_in_charge_id', 'it_hod_id', 'it_in_charge_id', 'admin_hod_id', 'admin_in_charge_id', 'accounts_hod_id', 'accounts_in_charge_id'], 'custom_index_for_unique');*/

            $table->foreign('hr_hod_id')->references('id')->on('employees');
            $table->foreign('hr_in_charge_id')->references('id')->on('employees');

            $table->foreign('it_hod_id')->references('id')->on('employees');
            $table->foreign('it_in_charge_id')->references('id')->on('employees');

            $table->foreign('admin_hod_id')->references('id')->on('employees');
            $table->foreign('admin_in_charge_id')->references('id')->on('employees');

            $table->foreign('accounts_hod_id')->references('id')->on('employees');
            $table->foreign('accounts_in_charge_id')->references('id')->on('employees');

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
        Schema::dropIfExists('closing_clearance_settings');
    }
}
