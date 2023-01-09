<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_salaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id')->unsigned();
            $table->bigInteger('payment_type_id')->unsigned()->nullable();
            $table->bigInteger('pay_cycle_id')->unsigned()->nullable();
            $table->bigInteger('bank_info_id')->unsigned()->nullable();
            $table->bigInteger('bank_branch_id')->unsigned()->nullable();
            $table->string('bank_account')->nullable();
            $table->tinyInteger('type');
            $table->decimal('gross_salary', 8, 2);
            $table->decimal('pf', 8, 2)->nullable();
            $table->boolean('pf_status')->default(1);
            $table->decimal('tax', 8, 2)->nullable();
            $table->boolean('tax_status')->default(1);
            $table->decimal('total_deduction', 8, 2)->nullable();
            $table->decimal('payable', 8, 2)->nullable();

            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('restrict');
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('restrict');
            $table->foreign('pay_cycle_id')->references('id')->on('pay_cycles')->onDelete('restrict');
            $table->foreign('bank_info_id')->references('id')->on('bank_infos')->onDelete('restrict');
            $table->foreign('bank_branch_id')->references('id')->on('bank_branches')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('individual_salaries');
    }
}
