<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidentFundSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provident_fund_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedDecimal('amount', 8, 2)->nullable();
            $table->decimal('pf_year', 2, 1)->nullable();
            $table->decimal('gratuity_year', 2, 1)->nullable();
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
        Schema::dropIfExists('provident_fund_settings');
    }
}
