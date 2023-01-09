<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('set_leaves', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name');
            $table->integer('hourly_quantity');
            $table->integer('contractual_quantity');
            $table->integer('permanent_quantity');
            $table->integer('probation_quantity');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('set_leaves');
    }
}
