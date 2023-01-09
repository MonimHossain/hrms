<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsvUploadLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csv_upload_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('total_number_of_row');
            $table->integer('faild_qnt');
            $table->integer('success_qnt');
            $table->bigInteger('emp_id');
            $table->text('remarks');
            $table->integer('csv_upload_logable_id');
            $table->string('csv_upload_logable_type');
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
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
        Schema::dropIfExists('import_csvs');
    }
}
