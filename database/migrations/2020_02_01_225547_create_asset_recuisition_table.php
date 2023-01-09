<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetRecuisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_recuisition', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('asset_type_id');
            $table->bigInteger('employee_id');            
            $table->text('specification')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->dateTime('due_date')->nullable();
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
        Schema::dropIfExists('asset_recuisition');
    }
}
