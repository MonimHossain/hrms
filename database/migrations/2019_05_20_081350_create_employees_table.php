<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->bigInteger('division_id')->unsigned()->nullable();
            //$table->bigInteger('center_id')->unsigned()->nullable();
            $table->bigInteger('nearby_location_id')->unsigned()->nullable();
            $table->bigInteger('blood_group_id')->unsigned()->nullable();
            $table->string('login_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('employer_id')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('personal_email')->unique()->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('religion')->nullable();
            $table->string('ssc_reg_num')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('alt_contact_number')->nullable();
            $table->string('pool_phone_number')->nullable();
            $table->string('emergency_contact_person')->nullable();
            $table->string('emergency_contact_person_number')->nullable();
            $table->string('relation_with_employee')->nullable();
            //$table->string('bank_name')->nullable();
            //$table->string('bank_branch')->nullable();
            //$table->string('bank_account')->nullable();
            //$table->string('bank_routing')->nullable();
            $table->string('nid')->nullable();
            $table->string('passport')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('spouse_name')->nullable();
            $table->date('spouse_dob')->nullable();
            $table->string('child1_name')->nullable();
            $table->date('child1_dob')->nullable();
            $table->string('child2_name')->nullable();
            $table->date('child2_dob')->nullable();
            $table->string('child3_name')->nullable();
            $table->date('child3_dob')->nullable();
            $table->string('profile_image')->nullable();
            $table->integer('profile_completion')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();


            //$table->foreign('division_id')->references('id')->on('divisions')->onDelete('restrict');
            //$table->foreign('center_id')->references('id')->on('centers')->onDelete('restrict');
            $table->foreign('blood_group_id')->references('id')->on('blood_groups')->onDelete('restrict');
            $table->foreign('nearby_location_id')->references('id')->on('nearby_locations')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
