<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOwnershipToAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //$tableList = ['document_header_templates', 'document_req_templates', 'documents', 'document_req_histories','centers','employment_types','departments',
        //    'document_templates','letter_and_documents','doc_setups','teams', 'process_segments', 'processes', 'employees', 'employee_statuses', 'designations'];
        //foreach ($tableList as $table) {
        //    Schema::table($table, function (Blueprint $table) {
        //        $table->bigInteger('created_by')->nullable();
        //        $table->bigInteger('updated_by')->nullable();
        //    });
        //}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */


   /* public function down()
    {

        $tableList = ['document_header_templates', 'document_req_templates', 'documents', 'document_req_histories','centers','employment_types','departments',
            'document_templates','letter_and_documents','doc_setups','teams', 'process_segments', 'processes', 'employees', 'employee_statuses', 'designations'];
        foreach ($tableList as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->bigInteger('created_by')->nullable();
                $table->bigInteger('updated_by')->nullable();
            });
        }
    }*/


        //$tableList = ['document_header_templates', 'document_req_templates', 'documents', 'document_req_histories','centers','employment_types','departments',
        //    'document_templates','letter_and_documents','doc_setups','teams', 'process_segments', 'processes', 'employees', 'employee_statuses', 'designations'];
        //foreach ($tableList as $table) {
        //    Schema::table($table, function (Blueprint $table) {
        //        $table->bigInteger('created_by')->nullable();
        //        $table->bigInteger('updated_by')->nullable();
        //    });
        //}
//    }

}
