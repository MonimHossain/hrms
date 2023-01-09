<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadEvaluationListChdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_evaluation_list_chds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('evaluation_mst')->unsigned()->comment('From Table = lead_evaluation_list_msts');
            $table->decimal('qst_mark')->nullable();
            $table->string('qst_type')->nullable();
            $table->bigInteger('qst_no')->unsigned()->comment('From table = appraisal_qst_msts');
            $table->string('qst_name', 250);
            $table->text('ans_text')->nullable();
            $table->json('ans_value')->nullable();

            $table->timestamps();

            $table->foreign('qst_no')->references('id')->on('appraisal_qst_msts');
            $table->foreign('evaluation_mst')->references('id')->on('lead_evaluation_list_msts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_evaluation_list_chds');
    }
}
