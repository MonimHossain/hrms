<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetAllocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_allocations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('asset_id');
            $table->bigInteger('employee_id');
            $table->bigInteger('allocated_by')->nullable();;
            $table->bigInteger('received_by')->nullable();;
            $table->dateTime('allocaiton_date')->index();
            $table->text('allocation_note')->nullable();
            $table->dateTime('return_date')->nullable();
            $table->text('return_note')->nullable();
            $table->decimal('damage_amount', 8, 2)->nullable();
            $table->tinyInteger('is_damaged')->default(0);
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
        Schema::dropIfExists('asset_allocations');
    }
}
