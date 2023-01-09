<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjustmentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjustment_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default(null);
            $table->bigInteger('created_by')->unsigned()->default(null);
            $table->bigInteger('updated_by')->unsigned()->default(null);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adjustment_types');
    }
}
