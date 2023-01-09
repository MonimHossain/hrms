<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSalaryHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_history', function (Blueprint $table) {
            $table->bigInteger('release_by')->after('is_hold')->nullable();
            $table->timestamp('release_at')->after('release_by')->nullable();
            $table->text('release_remarks')->after('release_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_history', function (Blueprint $table) {
            //
        });
    }
}
