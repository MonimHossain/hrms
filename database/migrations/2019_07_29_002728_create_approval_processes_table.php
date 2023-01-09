<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_processes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('from_id')->unsigned();
            $table->bigInteger('to_id')->unsigned();
            $table->integer('processable_id');
            $table->string('processable_type');
            $table->integer('status')->default(0);
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('approval_processes');
    }
}
