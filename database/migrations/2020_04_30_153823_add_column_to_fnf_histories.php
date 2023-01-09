<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToFnfHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnf_histories', function (Blueprint $table) {
            $table->decimal('adjustment_amount', 8, 2)->nullable()->after('payment_status');
            $table->decimal('payable_amount', 8, 2)->nullable()->after('adjustment_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnf_histories', function (Blueprint $table) {
            //
        });
    }
}
