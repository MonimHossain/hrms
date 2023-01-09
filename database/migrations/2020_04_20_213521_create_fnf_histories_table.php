<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnfHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fnf_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id')->unsigned();
            $table->bigInteger('application_id')->unsigned();
            $table->decimal('pf',8,2)->nullable();
            $table->decimal('gratuity',8,2)->nullable();
            $table->decimal('leave',8,2)->nullable();
            $table->decimal('encashment',8,2)->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->timestamp('payment_date')->nullable();
            $table->tinyInteger('payment_status')->nullable();

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('application_id')->references('id')->on('closing_applications');
            $table->foreign('created_by')->references('id')->on('employees');

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
        Schema::dropIfExists('fnf_histories');
    }
}
