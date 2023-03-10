<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToResourceLibsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resource_lib', function (Blueprint $table) {
            $table->tinyInteger('download_status')->unsigned()->comment('0 = not downloadable, 1 can be download');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resource_lib', function (Blueprint $table) {
            //
        });
    }
}
