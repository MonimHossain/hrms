<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSalarySummaryHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_summary_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('month')->index();
            $table->integer('employment_type_id');
            $table->decimal('total_amount', 8, 2);
            $table->integer('total_employee');
            $table->integer('total_hold');
            $table->integer('total_generated');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('salary_summary_history');
    }
}
