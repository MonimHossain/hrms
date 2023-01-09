<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndividualSalaryIdToIndividualSalaryBreakdownTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('individual_salary_breakdowns', function (Blueprint $table) {
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
        Schema::table('individual_salary_breakdowns', function (Blueprint $table) {
            $table->dropForeign('individual_salary_breakdowns_individual_salary_id_foreign');
        });
    }
}
