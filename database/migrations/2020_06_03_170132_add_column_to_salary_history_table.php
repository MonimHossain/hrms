<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToSalaryHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_history', function (Blueprint $table) {
            $table->dropColumn("kpi");
            $table->dropColumn("month");
        });


        Schema::table('salary_history', function (Blueprint $table) {
            $table->bigInteger('employment_type_id')->after('employee_id')->unsigned()->nullable();

            $table->string('month')->after('employment_type_id')->nullable();
            $table->date('start_date')->after('month')->nullable();
            $table->date('end_date')->after('start_date')->nullable();


            $table->decimal('payable_amount', 8, 2)->after('gross_salary');
            $table->decimal('kpi', 8, 2)->after('payable_amount')->nullable();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('employment_type_id')->references('id')->on('employment_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_history', function (Blueprint $table) {
            $table->dropForeign('salary_history_employee_id_foreign');
            $table->dropForeign('salary_history_employment_type_id_foreign');
        });
    }
}
