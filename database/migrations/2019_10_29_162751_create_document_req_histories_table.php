<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentReqHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_req_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref_id', '100');
            $table->tinyInteger('type_id');
            $table->text('content');
            $table->integer('employee_id');
            $table->integer('processed_by')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = new, 1 = processing, 2 = reject, 3 = done');
            $table->string('remarks', '300')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('document_req_histories');
    }
}
