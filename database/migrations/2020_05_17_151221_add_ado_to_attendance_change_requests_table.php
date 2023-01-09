<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdoToAttendanceChangeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendance_change_requests', function (Blueprint $table) {
            $table->boolean('is_adjusted_day_off')->default(0)->after('out_of_office');
            $table->boolean('status')->after('remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_change_requests', function (Blueprint $table) {
            //
        });
    }
}
