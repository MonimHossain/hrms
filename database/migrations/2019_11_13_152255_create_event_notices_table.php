<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_notices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('center_id');
            $table->tinyInteger('target_employee')->default(2);
            $table->string('title', 300);
            $table->text('content');
            $table->string('banner',100);
            $table->tinyInteger('is_event');
            $table->timestamp('event_date');
            $table->tinyInteger('status');
            $table->tinyInteger('is_pinned')->nullable();
            $table->tinyInteger('is_remainder')->nullable();
            $table->tinyInteger('is_mail')->nullable();
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
        Schema::dropIfExists('event_notices');
    }
}
