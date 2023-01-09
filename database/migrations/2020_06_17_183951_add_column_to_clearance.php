<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToClearance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clearance', function (Blueprint $table) {
            $table->timestamp('start_date')->after('month')->nullable();
            $table->timestamp('end_date')->after('start_date')->nullable();
            $table->text('remarks')->after('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clearance', function (Blueprint $table) {
            //
        });
    }
}
