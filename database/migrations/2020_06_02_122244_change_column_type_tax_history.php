<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnTypeTaxHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tax_histories', function(Blueprint $table)
        {
            $table->dropColumn('status');
        });

        Schema::table('tax_histories', function(Blueprint $table)
        {
            $table->tinyInteger('status')->after('remarks')->default(0);
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
