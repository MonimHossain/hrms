<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToProvidentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provident_histories', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
        });

        Schema::table('provident_histories', function (Blueprint $table) {
            $table->bigInteger('employee_id')->nullable()->change();
            $table->bigInteger('employer_id')->nullable()->after('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provident_histories', function (Blueprint $table) {
            //
        });
    }
}
