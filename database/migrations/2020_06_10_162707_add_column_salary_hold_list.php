<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSalaryHoldList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_hold_lists', function (Blueprint $table) {
            $table->tinyInteger('hold_reason')->after('status')->nullable();
            $table->bigInteger('release_by')->after('hold_reason')->nullable();
            $table->timestamp('release_at')->after('release_by')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_hold_lists', function (Blueprint $table) {
            //
        });
    }
}
