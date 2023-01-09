<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryGeneratedBreakdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('individual_salary_breakdowns', function (Blueprint $table) {
            $table->decimal('percentage', 5, 2)->change();
        });

        Schema::create('salary_generated_breakdowns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id')->unsigned();
            $table->bigInteger('salary_history_id')->unsigned();
            $table->string('name');
            $table->decimal('amount', 8, 2);
            $table->decimal('percentage', 5, 2);
            $table->boolean('is_basic')->default(0);
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('salary_history_id')->references('id')->on('salary_history')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_generated_breakdowns');
    }
}
