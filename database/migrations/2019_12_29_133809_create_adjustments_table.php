<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjustments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id')->unsigned();
            $table->bigInteger('adjustment_type')->unsigned();
            $table->enum('type',['deduction', 'addition']);
            $table->decimal('amount',8,2)->default(null);
            $table->tinyInteger('status');
            $table->timestamp('adjustment_date')->nullable();
            $table->text('remarks');
            $table->bigInteger('created_by')->unsigned()->default(null);
            $table->bigInteger('updated_by')->unsigned()->default(null);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('adjustment_type')->references('id')->on('adjustment_types')->onDelete('cascade');
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
        Schema::dropIfExists('adjustments');
    }
}
