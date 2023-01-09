<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToEmployeeHours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_hours', function (Blueprint $table) {
            $table->tinyInteger('check_status')->after('remarks')->nullable()->comment('1 = checked, 0 = unchecked');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_hours', function (Blueprint $table) {
            //
        });
    }
}
