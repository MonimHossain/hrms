<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessOrderingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('process_ordering', function (Blueprint $table) {
            //
        });

        Schema::create('process_ordering', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('order_number');
            $table->bigInteger('emp_id')->comment('This id from employee table');
            $table->bigInteger('team_workflow_id')->comment('This id from team_workfloe table');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('process_ordering');
    }
}
