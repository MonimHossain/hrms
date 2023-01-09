<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHiringRecruitmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hiring_recruitments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_title');
            $table->double('min_salary');
            $table->double('max_salary');
            $table->timestamp('expected_date');
            $table->tinyInteger('number_of_vacancy');
            $table->text('job_requirement');
            $table->text('job_description')->nullable();
            $table->bigInteger('approved_by');
            $table->tinyInteger('status')->default(0)->comment('0 = new request, 1= Processing, 2= Reject, 3= Done');
            $table->text('remarks')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('hiring_recruitments');
    }
}
