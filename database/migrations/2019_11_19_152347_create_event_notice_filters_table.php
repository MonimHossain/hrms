<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventNoticeFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_notice_filters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('division_id')->unsigned()->nullable();
            $table->bigInteger('center_id')->unsigned()->nullable();
            $table->tinyInteger('department_id')->unsigned()->nullable();
            $table->tinyInteger('process_id')->unsigned()->nullable();
            $table->tinyInteger('process_segment_id')->unsigned()->nullable();
            $table->bigInteger('event_notice_id');
            $table->timestamps();

            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
            /*$table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('process_id')->references('id')->on('processes');
            $table->foreign('process_segment_id')->references('id')->on('process_segments');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_notice_filters');
    }
}
