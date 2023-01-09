<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourceLibFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_lib_filters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('division_id')->unsigned()->nullable();
            $table->bigInteger('center_id')->unsigned()->nullable();
            $table->tinyInteger('department_id')->unsigned()->nullable();
            $table->tinyInteger('process_id')->unsigned()->nullable();
            $table->tinyInteger('process_segment_id')->unsigned()->nullable();
            $table->bigInteger('resource_lib_id');
            $table->timestamps();

            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_lib_filters');
    }
}
