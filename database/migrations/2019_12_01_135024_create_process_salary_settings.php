<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessSalarySettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_salary_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('division_id');
            $table->integer('center_id');
            $table->integer('department_id');
            $table->integer('process_id');
            $table->integer('process_segment_id');
            $table->tinyInteger('employment_type_id');
            $table->tinyInteger('salary_type');
            $table->unsignedDecimal('amount', 8, 2);
            $table->unsignedDecimal('kpi_boundary', 8, 2);
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
        Schema::dropIfExists('process_salary_settings');
    }
}
