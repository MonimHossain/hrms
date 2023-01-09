<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamEvaluationStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_evaluation_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('team_id')->unsigned();
            $table->bigInteger('evaluation_id')->unsigned();
            $table->enum('status', ['0', '1'])->default(0);
            $table->enum('lead_status', ['0', '1'])->default(0);
            $table->timestamp('completed_at');
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('evaluation_id')->references('id')->on('appraisal_evaluation_names');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_evaluation_statuses');
    }
}
