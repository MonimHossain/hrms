<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRosterChangeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roster_change_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id')->unsigned();
            $table->bigInteger('roster_id')->unsigned()->nullable();
            $table->date('date');
            // $table->date('end_date')->nullable();
            $table->string('off_days');
            // $table->boolean('is_revised')->default(0)->comment('0 = pending, 1 = approved');
            $table->boolean('is_approved')->default(0)->comment('0 = pending, 1 = approved');
            $table->dateTime('approved_on')->nullable();
            $table->bigInteger('approved_by')->unsigned()->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('roster_id')->references('id')->on('rosters')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roster_change_requests');
    }
}
