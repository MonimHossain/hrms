<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKpiOvertimeToIndividualSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('individual_salaries', function (Blueprint $table) {
            $table->tinyInteger('kpi_status')->after('type')->default(0);
            $table->tinyInteger('overtime_status')->after('type')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('individual_salaries', function (Blueprint $table) {
            //
        });
    }
}
