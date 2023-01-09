
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHourlyRatesToIndividualSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('individual_salaries', function (Blueprint $table) {
            $table->tinyInteger('bank_account_type')->after('bank_account')->nullable();
            $table->date('applicable_from')->after('type')->nullable();
            $table->date('applicable_to')->after('applicable_from')->nullable();
            $table->decimal('hourly_rate', 8, 2)->after('applicable_to')->nullable();
            $table->decimal('gross_salary', 8, 2)->nullable()->change();
            $table->tinyInteger('salary_status')->after('payable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('individual_salaries', function (Blueprint $table) {
            //
        });
    }
}
