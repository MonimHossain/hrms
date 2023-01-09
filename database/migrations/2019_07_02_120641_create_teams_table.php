<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('team_lead_id')->unsigned()->nullable();
//            $table->bigInteger('leave_rule_id')->unsigned()->nullable();
            $table->bigInteger('division_id')->unsigned()->nullable();
            $table->bigInteger('center_id')->unsigned()->nullable();
            $table->bigInteger('department_id')->unsigned()->nullable();
            $table->bigInteger('process_id')->unsigned()->nullable();
            $table->bigInteger('process_segment_id')->unsigned()->nullable();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->boolean('is_functional')->default('1');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('team_lead_id')->references('id')->on('employees')->onDelete('cascade');
//            $table->foreign('leave_rule_id')->references('id')->on('leave_rules')->onDelete('cascade');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('process_id')->references('id')->on('processes')->onDelete('cascade');
            $table->foreign('process_segment_id')->references('id')->on('process_segments')->onDelete('cascade');
        });

        Schema::table('teams', function (Blueprint $table)
        {
            $table->foreign('parent_id')->references('id')->on('teams')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
