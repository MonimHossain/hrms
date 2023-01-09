<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddDeleteUpdateCreateColumnToAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Echo to console here

        $tableList = DB::select('SHOW TABLES');
        foreach ($tableList as $tables) {
            foreach ($tables as $key => $tableName){
                if (Schema::hasTable($tableName)) {
                    Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                        if (!Schema::hasColumn($tableName, 'created_by')) {
                            $table->bigInteger('created_by')->nullable();
                        }
                        if (!Schema::hasColumn($tableName, 'updated_by')) {
                            $table->bigInteger('updated_by')->nullable()->after('created_by');
                        }
                        if (!Schema::hasColumn($tableName, 'deleted_by')) {
                            $table->bigInteger('deleted_by')->nullable()->after('updated_by');
                        }

                        if (!Schema::hasColumn($tableName, 'deleted_at')) {
                            $table->timestamp('deleted_at')->nullable()->after('deleted_by');
                        }

                        if (!Schema::hasColumn($tableName, 'created_at')) {
                            $table->timestamp('created_at')->nullable()->after('deleted_at');
                        }

                        if (!Schema::hasColumn($tableName, 'updated_at')) {
                            $table->timestamp('updated_at')->nullable()->after('created_at');
                        }

                    });
                }
            }
        }



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
