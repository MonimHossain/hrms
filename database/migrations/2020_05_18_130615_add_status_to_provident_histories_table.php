<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToProvidentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provident_histories', function (Blueprint $table) {
            $table->enum('status', array('due', 'payed'))->after('remarks')->nullable();
            $table->bigInteger('created_by')->nullable()->change();
            $table->bigInteger('updated_by')->nullable()->change();
        });
        Schema::table('tax_histories', function (Blueprint $table) {
            $table->enum('status', array('due', 'payed'))->after('remarks')->nullable();
            $table->bigInteger('created_by')->nullable()->change();
            $table->bigInteger('updated_by')->nullable()->change();
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
        Schema::table('tax_histories', function (Blueprint $table) {
            //
        });
    }
}
