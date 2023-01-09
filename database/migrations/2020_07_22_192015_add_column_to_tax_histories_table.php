<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToTaxHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tax_histories', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
        });

        Schema::table('tax_histories', function (Blueprint $table) {
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
        Schema::table('tax_histories', function (Blueprint $table) {
            //
        });
    }
}
