<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeIdForeignKeyConstantToAllMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /***************************************************
         ***************************************************
         ===== Remove employee id foreign key constant =====
         ***************************************************
         ***************************************************/


        // /*Tax history*/
        // Schema::table('tax_histories', function (Blueprint $table) {
        //     //$table->dropForeign(['employee_id']);
        // });

        // Schema::table('tax_histories', function (Blueprint $table) {
        //     //$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        // });



        // /*Local History*/
        // Schema::table('loan_applications', function (Blueprint $table) {
        //     //$table->dropForeign(['employee_id']);
        // });

        // Schema::table('loan_applications', function (Blueprint $table) {
        //     //$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        // });



        // /*Local General Application*/
        // Schema::table('loan_general_applications', function (Blueprint $table) {
        //     //$table->dropForeign(['employee_id']);
        // });

        // Schema::table('loan_general_applications', function (Blueprint $table) {
        //     //$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        // });



        // /*Salary Hold List*/
        // Schema::table('salary_hold_lists', function (Blueprint $table) {
        //     //$table->dropForeign(['employee_id']);
        // });

        // Schema::table('salary_hold_lists', function (Blueprint $table) {
        //      //$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        // });



        // /*Salary History*/
        // Schema::table('salary_history', function (Blueprint $table) {
        //     $table->dropForeign(['employee_id']);
        // });

        // Schema::table('salary_history', function (Blueprint $table) {
        //     $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        // });



        // /*Employee Hour=== Default it has no employee id constant so first time no need to delete it*/
        // Schema::table('employee_hours', function (Blueprint $table) {
        //     //$table->dropForeign(['employee_id']);
        // });

        // Schema::table('employee_hours', function (Blueprint $table) {
        //     $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        // });




        // /*Closing Application*/
        // Schema::table('closing_applications', function (Blueprint $table) {
        //     $table->dropForeign(['employee_id']);
        // });

        // Schema::table('closing_applications', function (Blueprint $table) {
        //     $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        // });



        // /*Exist Interview Evaluation*/
        // Schema::table('exit_interview_evaluations', function (Blueprint $table) {
        //     $table->dropForeign(['employee_id']);
        // });

        // Schema::table('exit_interview_evaluations', function (Blueprint $table) {
        //     $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        // });




        // /*Appraisal Evaluation Name*/
        // Schema::table('employee_evaluation_list_msts', function (Blueprint $table) {
        //     $table->dropForeign(['employee_id']);
        // });


        // Schema::table('employee_evaluation_list_msts', function (Blueprint $table) {
        //     $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        // });




        // /*Yearly Appraisal CHD*/
        // Schema::table('yearly_appraisal_chds', function (Blueprint $table) {
        //     $table->dropForeign(['employee_id']);
        // });

        // Schema::table('yearly_appraisal_chds', function (Blueprint $table) {
        //     $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        // });



        // /*Lead Evaluation List MST*/
        // Schema::table('lead_evaluation_list_msts', function (Blueprint $table) {
        //     $table->dropForeign(['employee_id']);
        // });

        // Schema::table('lead_evaluation_list_msts', function (Blueprint $table) {
        //    $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        // });




        // /*FNF History*/
        // Schema::table('fnf_histories', function (Blueprint $table) {
        //     $table->dropForeign(['employee_id']);
        // });

        // Schema::table('fnf_histories', function (Blueprint $table) {
        //     $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        // });




        // /*Loan EMI*/
        // Schema::table('loan_emis', function (Blueprint $table) {
        //     //$table->dropForeign(['loan_id']);
        // });

        // Schema::table('loan_emis', function (Blueprint $table) {
        //     //$table->foreign('loan_id')->references('id')->on('loan_applications')->onDelete('cascade');
        // });


        // /*Appraisal KPI Percentage*/
        // Schema::table('appraisal_kpi_percentages', function (Blueprint $table) {
        //     //$table->dropForeign(['created_by', 'updated_by']);
        // });



        // /*Yearly Appraisal MST*/
        // Schema::table('yearly_appraisal_msts', function (Blueprint $table) {
        //     //$table->dropForeign(['created_by', 'updated_by']);
        // });



        // /*Appraisal Evaluation Name*/
        // Schema::table('appraisal_evaluation_names', function (Blueprint $table) {
        //     //$table->dropForeign(['created_by']);
        // });



        // /*Appraisal Question History*/
        // Schema::table('appraisal_qst_chds', function (Blueprint $table) {
        //     //$table->dropForeign(['created_by']);
        // });


        // /*Appraisal Question History*/
        // Schema::table('appraisal_qst_chds', function (Blueprint $table) {
        //     //$table->dropForeign(['application_id', 'created_by']);
        // });


        // /*Employee Evaluation List MST*/
        // Schema::table('employee_evaluation_list_msts', function (Blueprint $table) {
        //     //$table->dropForeign(['team_id']);
        // });


        // /*Yearly Appraisal CHD*/
        // Schema::table('yearly_appraisal_chds', function (Blueprint $table) {
        //     //$table->dropForeign(['recommendation_by', 'approved_by']);
        // });



        // /*Lead Evaluation List MST*/
        // Schema::table('lead_evaluation_list_msts', function (Blueprint $table) {
        //     //$table->dropForeign(['lead_id']);
        // });













        /*==================No Need Below Code====================*/

        /*Schema::table('closing_clearance_settings', function (Blueprint $table) {
            $table->dropForeign(['hr_hod_id', 'hr_in_charge_id', 'it_hod_id', 'it_in_charge_id', 'admin_hod_id','admin_in_charge_id', 'accounts_hod_id', 'accounts_in_charge_id', 'created_by', 'updated_by']);
        });*/


        /*Schema::table('closing_clearance_statuses', function (Blueprint $table) {
            //$table->dropForeign(['hr_hod_by', 'hr_hod_by', 'hr_in_charge_by', 'it_hod_by', 'it_in_charge_by', 'admin_hod_by','admin_in_charge_by', 'accounts_hod_by', 'accounts_in_charge_by', 'own_dept_hod_by', 'closing_applications_id']);
        });*/

        /*New add*/
        /*Schema::table('asset_allocations', function (Blueprint $table) {
            //$table->dropForeign(['employee_id']);
        });*/

        /*Schema::table('departments', function (Blueprint $table) {
            //$table->dropForeign(['own_hod_id', 'own_in_charge_id']);
        });*/

        /*Schema::table('bonuses', function (Blueprint $table) {
            $table->dropForeign(['employee_id', 'created_by', 'updated_by']);
        });*/




        /***************************************************
         ***************************************************
         =====  Add employee id foreign key constant   =====
         ***************************************************
         ***************************************************/


        /*Schema::table('bonuses', function (Blueprint $table) {
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });


        Schema::table('closing_clearance_statuses', function (Blueprint $table) {
            //$table->unsignedInteger('closing_applications_id');
            //$table->foreign('closing_applications_id')->references('id')->on('closing_applications')->onDelete('cascade');
        });

        Schema::table('asset_allocations', function (Blueprint $table) {
            //$table->unsignedInteger('employee_id');
            //$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });

        Schema::table('asset_recuisition', function (Blueprint $table) {
            //$table->unsignedInteger('employee_id');
            //$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });

       Schema::table('employee_attendance_summary', function (Blueprint $table) {
            //$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });*/






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
