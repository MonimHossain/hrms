<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReasonsToLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->string('subject')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->bigInteger('leave_reason_id')->after('end_date')->unsigned()->nullable();

            $table->foreign('leave_reason_id')->references('id')->on('leave_reasons')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropForeign('leave_reason_id');
        });
    }
}
