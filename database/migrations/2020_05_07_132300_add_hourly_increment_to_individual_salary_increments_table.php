<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHourlyIncrementToIndividualSalaryIncrementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('individual_salary_increments', function (Blueprint $table) {
        //     $table->dropForeign('individual_salary_increments_individual_salary_id_foreign');
        // });
        Schema::table('individual_salary_increments', function (Blueprint $table) {
            $table->renameColumn('effective_from', 'applicable_from');
        });
        Schema::table('individual_salary_increments', function (Blueprint $table) {
            $table->decimal('last_gross_salary', 8, 2)->nullable()->change();
            $table->decimal('current_gross_salary', 8, 2)->nullable()->change();
            $table->decimal('incremented_amount', 8, 2)->nullable()->change();



            $table->bigInteger('individual_salary_id')->unsigned()->nullable()->after('employee_id');
            $table->tinyInteger('type')->after('individual_salary_id')->nullable();
            $table->date('applicable_from')->after('type')->nullable()->change();
            $table->date('applicable_to')->after('applicable_from')->nullable();
            $table->decimal('last_hourly_rate', 8, 2)->after('applicable_to')->nullable();
            $table->decimal('current_hourly_rate', 8, 2)->after('last_hourly_rate')->nullable();
            $table->decimal('incremented_hourly_rate', 8, 2)->after('current_hourly_rate')->nullable();

            $table->decimal('pf', 8, 2)->after('incremented_amount')->nullable();
            $table->boolean('pf_status')->after('pf')->default(1);
            $table->decimal('tax', 8, 2)->after('pf_status')->nullable();
            $table->boolean('tax_status')->after('tax')->default(1);
            $table->decimal('total_deduction', 8, 2)->after('tax_status')->nullable();
            $table->decimal('payable', 8, 2)->after('total_deduction')->nullable();

            $table->tinyInteger('salary_status')->after('incremented_hourly_rate');

            $table->foreign('individual_salary_id')->references('id')->on('individual_salaries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('individual_salary_increments', function (Blueprint $table) {
            $table->renameColumn('applicable_from', 'effective_from');
            $table->dropForeign('individual_salary_increments_individual_salary_id_foreign');
        });
    }
}
