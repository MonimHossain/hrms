<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewQstChdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_qst_chds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('mst_id')->unsigned();
            $table->string('label', 50);
            $table->tinyInteger('value');
            $table->enum('type', ['radio', 'check', 'textarea', 'input']);
            $table->bigInteger('created_by')->unsigned();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('employees');
            $table->foreign('mst_id')->references('id')->on('interview_qst_msts')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interview_qst_chds');
    }
}
