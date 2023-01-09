<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEarnLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earn_leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id')->unsigned();
            $table->date('eligible_date');
            $table->string('year');
            $table->decimal('earn_balance', 5, 2);
            $table->decimal('forwarded_balance', 5, 2)->nullable();
            $table->decimal('total_balance', 5, 2);
            $table->boolean('is_usable');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });

        Schema::table('leave_balances', function (Blueprint $table) {
            $table->boolean('is_usable')->default(1)->after('remain');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('earn_leaves');
    }
}
