<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndividualSalaryIdToIndividualOtherAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('individual_other_allowances', function (Blueprint $table) {
            $table->bigInteger('individual_salary_id')->unsigned()->nullable()->after('employee_id');

            $table->foreign('individual_salary_id')->references('id')->on('individual_salaries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('individual_other_allowances', function (Blueprint $table) {
            $table->dropForeign('individual_other_allowances_individual_salary_id_foreign');
        });
    }
}
