<?php

namespace App\Utils;

interface Permissions
{

    // Admin Permissions
    // Employee module
    const EMPLOYEE_LIST_VIEW = 'Employee List View';
    const EMPLOYEE_PROFILE_VIEW = 'Employee Profile View';
    const EMPLOYEE_CREATE = 'Employee Create';
    const EMPLOYEE_EDIT = 'Employee Edit';
    const EMPLOYEE_DELETE = 'Employee Delete';
    // impersonate
    const IMPERSONATE_VIEW = 'Employee Impersonate View';

    // Team module
    const ADMIN_TEAM_VIEW = 'Admin Team View';
    const ADMIN_TEAM_CREATE = 'Admin Team Create';
    const ADMIN_TEAM_EDIT = 'Admin Team Edit';
    const ADMIN_TEAM_DELETE = 'Admin Team Delete';

    // Leave module
    const ADMIN_LEAVE_VIEW = 'Admin Leave View';
    const ADMIN_LEAVE_CREATE = 'Admin Leave Create';
    const ADMIN_LEAVE_EDIT = 'Admin Leave Edit';
    const ADMIN_LEAVE_DELETE = 'Admin Leave Delete';

    // Leave approval module
    const ADMIN_LEAVE_APPROVAL_VIEW = 'Admin Leave Approval View';
    const ADMIN_LEAVE_APPROVAL_CREATE = 'Admin Leave Approval Create';
    const ADMIN_LEAVE_APPROVAL_EDIT = 'Admin Leave Approval Edit';
    const ADMIN_LEAVE_APPROVAL_DELETE = 'Admin Leave Approval Delete';

    // Roster module
    const ADMIN_ROSTER_VIEW = 'Admin Roster View';
    const ADMIN_ROSTER_CREATE = 'Admin Roster Create';
    const ADMIN_ROSTER_EDIT = 'Admin Roster Edit';
    const ADMIN_ROSTER_DELETE = 'Admin Roster Delete';

    // Attendance module
    const ADMIN_ATTENDANCE_VIEW = 'Admin Attendance View';
    const ADMIN_ATTENDANCE_CREATE = 'Admin Attendance Create';
    const ADMIN_ATTENDANCE_EDIT = 'Admin Attendance Edit';
    const ADMIN_ATTENDANCE_DELETE = 'Admin Attendance Delete';

    // Employee Hours upload module
    const ADMIN_EMPLOYEE_HOURS_VIEW = 'Admin Employee Hours View';
    const ADMIN_EMPLOYEE_HOURS_CREATE = 'Admin Employee Hours Create';
    const ADMIN_EMPLOYEE_HOURS_EDIT = 'Admin Employee Hours Edit';
    const ADMIN_EMPLOYEE_HOURS_DELETE = 'Admin Employee Hours Delete';

    // Admin Letter And Documents
    const ADMIN_LETTER_AND_DOCUMENTS_VIEW = 'Admin Letter And Documents View';
    const ADMIN_LETTER_AND_DOCUMENTS_CREATE = 'Admin Letter And Documents Create';
    const ADMIN_LETTER_AND_DOCUMENTS_EDIT = 'Admin Letter And Documents Edit';
    const ADMIN_LETTER_AND_DOCUMENTS_DELETE = 'Admin Letter And Documents Delete';

    // Admin Letter And Documents
    const ADMIN_NOTICE_AND_EVENT_VIEW = 'Admin Notice And Event View';
    const ADMIN_NOTICE_AND_EVENT_CREATE = 'Admin Notice And Event Create';
    const ADMIN_NOTICE_AND_EVENT_EDIT = 'Admin Notice And Event Edit';
    const ADMIN_NOTICE_AND_EVENT_DELETE = 'Admin Notice And Event Delete';

    // Role module
    const ADMIN_ROLE_VIEW = 'Role View';
    const ADMIN_ROLE_CREATE = 'Role Create';
    const ADMIN_ROLE_EDIT = 'Role Edit';
    const ADMIN_ROLE_DELETE = 'Role Delete';

    // Permission module
    const ADMIN_PERMISSION_VIEW = 'Permission View';
    const ADMIN_PERMISSION_CREATE = 'Permission Create';
    const ADMIN_PERMISSION_EDIT = 'Permission Edit';
    const ADMIN_PERMISSION_DELETE = 'Permission Delete';

    // General Settings module
    const ADMIN_GENERAL_SETTINGS_VIEW = 'General Settings View';
    const ADMIN_GENERAL_SETTINGS_CREATE = 'General Settings Create';
    const ADMIN_GENERAL_SETTINGS_EDIT = 'General Settings Edit';
    const ADMIN_GENERAL_SETTINGS_DELETE = 'General Settings Delete';

    // Workflow Settings module
    const ADMIN_WORKFLOW_SETTINGS_VIEW = 'Workflow Settings View';
    const ADMIN_WORKFLOW_SETTINGS_CREATE = 'Workflow Settings Create';
    const ADMIN_WORKFLOW_SETTINGS_EDIT = 'Workflow Settings Edit';
    const ADMIN_WORKFLOW_SETTINGS_DELETE = 'Workflow Settings Delete';


    // payroll
    //salary
    const ADMIN_SALARY_VIEW = 'Admin Salary View';
    const ADMIN_SALARY_CREATE = 'Admin Salary Create';
    const ADMIN_SALARY_EDIT = 'Admin Salary Edit';
    const ADMIN_SALARY_DELETE = 'Admin Salary Delete';

    // salary adjustment
    const ADMIN_SALARY_ADJUSTMENT_VIEW = 'Admin Salary Adjustment View';
    const ADMIN_SALARY_ADJUSTMENT_CREATE = 'Admin Salary Adjustment Create';
    const ADMIN_SALARY_ADJUSTMENT_EDIT = 'Admin Salary Adjustment Edit';
    const ADMIN_SALARY_ADJUSTMENT_DELETE = 'Admin Salary Adjustment Delete';

    // salary hold
    const ADMIN_SALARY_HOLD_VIEW = 'Admin Salary Hold View';
    const ADMIN_SALARY_HOLD_CREATE = 'Admin Salary Hold Create';
    const ADMIN_SALARY_HOLD_EDIT = 'Admin Salary Hold Edit';
    const ADMIN_SALARY_HOLD_DELETE = 'Admin Salary Hold Delete';

    // salary bonus
    const ADMIN_SALARY_BONUS_VIEW = 'Admin Salary Bonus View';
    const ADMIN_SALARY_BONUS_CREATE = 'Admin Salary Bonus Create';
    const ADMIN_SALARY_BONUS_EDIT = 'Admin Salary Bonus Edit';
    const ADMIN_SALARY_BONUS_DELETE = 'Admin Salary Bonus Delete';

    // kpi
    const ADMIN_KPI_VIEW = 'Admin KPI View';
    const ADMIN_KPI_CREATE = 'Admin KPI Create';
    const ADMIN_KPI_EDIT = 'Admin KPI Edit';
    const ADMIN_KPI_DELETE = 'Admin KPI Delete';

    // tax
    const ADMIN_TAX_VIEW = 'Admin Tax View';
    const ADMIN_TAX_CREATE = 'Admin Tax Create';
    const ADMIN_TAX_EDIT = 'Admin Tax Edit';
    const ADMIN_TAX_DELETE = 'Admin Tax Delete';

    // PF
    const ADMIN_PROVIDENT_FUND_VIEW = 'Admin Provident Fund View';
    const ADMIN_PROVIDENT_FUND_CREATE = 'Admin Provident Fund Create';
    const ADMIN_PROVIDENT_FUND_EDIT = 'Admin Provident Fund Edit';
    const ADMIN_PROVIDENT_FUND_DELETE = 'Admin Provident Fund Delete';

    // Loan
    const ADMIN_LOAN_VIEW = 'Admin Loan View';
    const ADMIN_LOAN_CREATE = 'Admin Loan Create';
    const ADMIN_LOAN_EDIT = 'Admin Loan Edit';
    const ADMIN_LOAN_DELETE = 'Admin Loan Delete';

    // Admin Employee Hour
    const ADMIN_EMPLOYEE_HOUR_VIEW = 'Admin Employee Hour View';
    const ADMIN_EMPLOYEE_HOUR_CREATE = 'Admin Employee Hour Create';
    const ADMIN_EMPLOYEE_HOUR_EDIT = 'Admin Employee Hour Edit';
    const ADMIN_EMPLOYEE_HOUR_DELETE = 'Admin Employee Hour Delete';


    // Asset
    const ADMIN_ASSET_VIEW = 'Admin Asset View';
    const ADMIN_ASSET_CREATE = 'Admin Asset Create';
    const ADMIN_ASSET_EDIT = 'Admin Asset Edit';
    const ADMIN_ASSET_DELETE = 'Admin Asset Delete';

    // Resource Library
    const ADMIN_RESOURCE_LIBRARY_VIEW = 'Admin Resource Library View';
    const ADMIN_RESOURCE_LIBRARY_CREATE = 'Admin Resource Library Create';
    const ADMIN_RESOURCE_LIBRARY_EDIT = 'Admin Resource Library Edit';
    const ADMIN_RESOURCE_LIBRARY_DELETE = 'Admin Resource Library Delete';

    // Recruitment
    const ADMIN_RECRUITMENT_VIEW = 'Admin Recruitment View';
    const ADMIN_RECRUITMENT_CREATE = 'Admin Recruitment Create';
    const ADMIN_RECRUITMENT_EDIT = 'Admin Recruitment Edit';
    const ADMIN_RECRUITMENT_DELETE = 'Admin Recruitment Delete';

    // User Permissions
    // Team module
    const TEAM_VIEW = 'Team View';
    const TEAM_CREATE = 'Team Create';
    const TEAM_EDIT = 'Team Edit';
    const TEAM_DELETE = 'Team Delete';
    // Supervisor module
    const SUPERVISOR_VIEW = 'Supervisor View';
    const SUPERVISOR_CREATE = 'Supervisor Create';
    const SUPERVISOR_EDIT = 'Supervisor Edit';
    const SUPERVISOR_DELETE = 'Supervisor Delete';
    // User Roster
    const USER_ROSTER_VIEW = 'User Roster View';
    const USER_ROSTER_CREATE = 'User Roster Create';
    const USER_ROSTER_EDIT = 'User Roster Edit';
    const USER_ROSTER_DELETE = 'User Roster Delete';
    // User Attendance
    const USER_ATTENDANCE_VIEW = 'User Attendance View';
    const USER_ATTENDANCE_CREATE = 'User Attendance Create';
    const USER_ATTENDANCE_EDIT = 'User Attendance Edit';
    const USER_ATTENDANCE_DELETE = 'User Attendance Delete';


    /*Appraisal*/
    const APPRAISAL_SETTING_VIEW = 'Appraisal Setting View';
    const APPRAISAL_SETTING_CREATE = 'Appraisal Setting Create';
    const APPRAISAL_SETTING_EDIT = 'Appraisal Setting Edit';
    const APPRAISAL_SETTING_DELETE = 'Appraisal Setting Delete';

    const APPRAISAL_APPRAISAL_VIEW = 'Appraisal Appraisal View';
    const APPRAISAL_APPRAISAL_CREATE = 'Appraisal Appraisal Create';

    const APPRAISAL_EVALUATION_VIEW = 'Appraisal Evaluation View';
    const APPRAISAL_EVALUATION_CREATE = 'Appraisal Evaluation Create';
    const APPRAISAL_EVALUATION_EDIT = 'Appraisal Evaluation Edit';

    const APPRAISAL_REPORT_VIEW = 'Appraisal Report View';
    const APPRAISAL_REPORT_CREATE = 'Appraisal Report Create';
    const APPRAISAL_REPORT_EDIT = 'Appraisal Report Edit';
    const APPRAISAL_REPORT_DELETE = 'Appraisal Report Delete';

    /*Employee Closing*/
    const EMPLOYEE_CLOSING_SEPARATION_VIEW = 'Employee Closing Separation View';
    const EMPLOYEE_CLOSING_SEPARATION_CREATE = 'Employee Closing Separation Create';
    const EMPLOYEE_CLOSING_SEPARATION_EDIT = 'Employee Closing Separation Edit';
    const EMPLOYEE_CLOSING_SEPARATION_DELETE = 'Employee Closing Separation Delete';

    const EMPLOYEE_CLOSING_REPORT_VIEW = 'Employee Closing Report View';
    const EMPLOYEE_CLOSING_REPORT_CREATE = 'Employee Closing Report Create';
    const EMPLOYEE_CLOSING_REPORT_EDIT = 'Employee Closing Report Edit';
    const EMPLOYEE_CLOSING_REPORT_DELETE = 'Employee Closing Report Delete';

    const EMPLOYEE_CLOSING_SETTING_VIEW = 'Employee Closing Setting View';
    const EMPLOYEE_CLOSING_SETTING_CREATE = 'Employee Closing Setting Create';
    const EMPLOYEE_CLOSING_SETTING_EDIT = 'Employee Closing Setting Edit';
    const EMPLOYEE_CLOSING_SETTING_DELETE = 'Employee Closing Setting Delete';

    /*Employee Hourly Upload*/
    const EMPLOYEE_HOUR_UPLOAD_VIEW = 'Employee Hour Upload View';
    const EMPLOYEE_HOUR_UPLOAD_CREATE = 'Employee Hour Upload Create';
    const EMPLOYEE_HOUR_UPLOAD_EDIT = 'Employee Hour Upload Edit';
    const EMPLOYEE_HOUR_UPLOAD_DELETE = 'Employee Hour Upload Delete';

    /*Employee Type Permanent*/
    const MANAGE_SALARY_PERMANENT_VIEW = 'Manage Salary Permanent View';
    const MANAGE_SALARY_PERMANENT_CREATE = 'Manage Salary Permanent Create';
    const MANAGE_SALARY_PERMANENT_EDIT = 'Manage Salary Permanent Edit';
    const MANAGE_SALARY_PERMANENT_DELETE = 'Manage Salary Permanent Delete';

    /*Employee Type Contractual*/
    const MANAGE_SALARY_CONTRACTUAL_VIEW = 'Manage Salary Contractual View';
    const MANAGE_SALARY_CONTRACTUAL_CREATE = 'Manage Salary Contractual Create';
    const MANAGE_SALARY_CONTRACTUAL_EDIT = 'Manage Salary Contractual Edit';
    const MANAGE_SALARY_CONTRACTUAL_DELETE = 'Manage Salary Contractual Delete';

    /*Employee Type Hourly*/
    const MANAGE_SALARY_HOURLY_VIEW = 'Manage Salary Hourly View';
    const MANAGE_SALARY_HOURLY_CREATE = 'Manage Salary Hourly Create';
    const MANAGE_SALARY_HOURLY_EDIT = 'Manage Salary Hourly Edit';
    const MANAGE_SALARY_HOURLY_DELETE = 'Manage Salary Hourly Delete';

    /*Clearance*/
    const EMPLOYEE_HOUR_CLEARANCE_VIEW = 'Employee Hour Clearance View';
    const EMPLOYEE_HOUR_CLEARANCE_CREATE = 'Employee Hour Clearance Create';
    const EMPLOYEE_HOUR_CLEARANCE_EDIT = 'Employee Hour Clearance Edit';
    const EMPLOYEE_HOUR_CLEARANCE_DELETE = 'Employee Hour Clearance Delete';

    const PROVIDENT_FOUND_CLEARANCE_VIEW = 'Provident Found Clearance View';
    const PROVIDENT_FOUND_CLEARANCE_CREATE = 'Provident Found Clearance Create';
    const PROVIDENT_FOUND_CLEARANCE_EDIT = 'Provident Found Clearance Edit';
    const PROVIDENT_FOUND_CLEARANCE_DELETE = 'Provident Found Clearance Delete';

    const TAX_CLEARANCE_VIEW = 'Tax Clearance View';
    const TAX_CLEARANCE_CREATE = 'Tax Clearance Create';
    const TAX_CLEARANCE_EDIT = 'Tax Clearance Edit';
    const TAX_CLEARANCE_DELETE = 'Tax Clearance Delete';

    const ADJUSTMENT_CLEARANCE_VIEW = 'Adjustment Clearance View';
    const ADJUSTMENT_CLEARANCE_CREATE = 'Adjustment Clearance Create';
    const ADJUSTMENT_CLEARANCE_EDIT = 'Adjustment Clearance Edit';
    const ADJUSTMENT_CLEARANCE_DELETE = 'Adjustment Clearance Delete';

    const SALARY_HOLD_CLEARANCE_VIEW = 'Salary Hold Clearance View';
    const SALARY_HOLD_CLEARANCE_CREATE = 'Salary Hold Clearance Create';
    const SALARY_HOLD_CLEARANCE_EDIT = 'Salary Hold Clearance Edit';
    const SALARY_HOLD_CLEARANCE_DELETE = 'Salary Hold Clearance Delete';

    /*Manage Salary*/
    const MANGE_SALARY_SETUP_VIEW = 'Manage Salary Setup View';
    const MANGE_SALARY_SETUP_CREATE = 'Manage Salary Setup Create';
    const MANGE_SALARY_SETUP_EDIT = 'Manage Salary Setup Edit';
    const MANGE_SALARY_SETUP_DELETE = 'Manage Salary Setup Delete';

    const MANGE_ADMIN_SALARY_SETUP_VIEW = 'Manage Admin Salary Setup View';
    const MANGE_ADMIN_SALARY_SETUP_CREATE = 'Manage Admin Salary Setup Create';
    const MANGE_ADMIN_SALARY_SETUP_EDIT = 'Manage Admin Salary Setup Edit';
    const MANGE_ADMIN_SALARY_SETUP_DELETE = 'Manage Admin Salary Setup Delete';

    const SALARY_HISTORY_VIEW = 'Salary History View';
    const SALARY_HISTORY_CREATE = 'Salary History Create';
    const SALARY_HISTORY_EDIT = 'Salary History Edit';
    const SALARY_HISTORY_DELETE = 'Salary History Delete';

    const SALARY_GENERATE_VIEW = 'Salary Generate View';
    const SALARY_GENERATE_CREATE = 'Salary Generate Create';
    const SALARY_GENERATE_EDIT = 'Salary Generate Edit';
    const SALARY_GENERATE_DELETE = 'Salary Generate Delete';

    /* HOD and In Charge Permission Module */
    const HR_HOD_VIEW = 'Hr HOD View';
    const HR_HOD_CREATE = 'Hr HOD Create';
    const HR_HOD_EDIT = 'Hr HOD Edit';
    const HR_HOD_DELETE = 'Hr HOD Delete';

    const HR_IN_CHARGE_VIEW = 'Hr In Charge View';
    const HR_IN_CHARGE_CREATE = 'Hr In Charge Create';
    const HR_IN_CHARGE_EDIT = 'Hr In Charge Edit';
    const HR_IN_CHARGE_DELETE = 'Hr In Charge Delete';

    const IT_HOD_VIEW = 'IT HOD View';
    const IT_HOD_CREATE = 'IT HOD Create';
    const IT_HOD_EDIT = 'IT HOD Edit';
    const IT_HOD_DELETE = 'IT HOD Delete';

    const IT_IN_CHARGE_VIEW = 'IT In Charge View';
    const IT_IN_CHARGE_CREATE = 'IT In Charge Create';
    const IT_IN_CHARGE_EDIT = 'IT In Charge Edit';
    const IT_IN_CHARGE_DELETE = 'IT In Charge Delete';

    const ADMIN_HOD_VIEW = 'Admin HOD View';
    const ADMIN_HOD_CREATE = 'Admin HOD Create';
    const ADMIN_HOD_EDIT = 'Admin HOD Edit';
    const ADMIN_HOD_DELETE = 'Admin HOD Delete';

    const ADMIN_IN_CHARGE_VIEW = 'Admin In Charge View';
    const ADMIN_IN_CHARGE_CREATE = 'Admin In Charge Create';
    const ADMIN_IN_CHARGE_EDIT = 'Admin In Charge Edit';
    const ADMIN_IN_CHARGE_DELETE = 'Admin In Charge Delete';

    const ACCOUNTS_HOD_VIEW = 'Accounts HOD View';
    const ACCOUNTS_HOD_CREATE = 'Accounts HOD Create';
    const ACCOUNTS_HOD_EDIT = 'Accounts HOD Edit';
    const ACCOUNTS_HOD_DELETE = 'Accounts HOD Delete';

    const ACCOUNTS_IN_CHARGE_VIEW = 'Accounts In Charge View';
    const ACCOUNTS_IN_CHARGE_CREATE = 'Accounts In Charge Create';
    const ACCOUNTS_IN_CHARGE_EDIT = 'Accounts In Charge Edit';
    const ACCOUNTS_IN_CHARGE_DELETE = 'Accounts In Charge Delete';


    /*Employee Attendance Upload*/
    const EMPLOYEE_ATTENDANCE_UPLOAD_VIEW = 'Employee Attendance Upload View';
    const EMPLOYEE_ATTENDANCE_UPLOAD_CREATE = 'Employee Attendance Upload Create';
    const EMPLOYEE_ATTENDANCE_UPLOAD_EDIT = 'Employee Attendance Upload Edit';
    const EMPLOYEE_ATTENDANCE_UPLOAD_DELETE = 'Employee Attendance Upload Delete';

    const EMPLOYEE_ATTENDANCE_CLEARANCE_VIEW = 'Employee Attendance Clearance View';
    const EMPLOYEE_ATTENDANCE_CLEARANCE_CREATE = 'Employee Attendance Clearance Create';
    const EMPLOYEE_ATTENDANCE_CLEARANCE_EDIT = 'Employee Attendance Clearance Create';
    const EMPLOYEE_ATTENDANCE_CLEARANCE_DELETE = 'Employee Attendance Clearance Delete';


    /* Admin Permanent Salary */

    const MANGE_PERMANENT_SALARY_SETUP_VIEW     = 'Admin Permanent Salary View';
    const MANGE_PERMANENT_SALARY_SETUP_CREATE   = 'Admin Permanent Salary Create';
    const MANGE_PERMANENT_SALARY_SETUP_EDIT     = 'Admin Permanent Salary Edit';
    const MANGE_PERMANENT_SALARY_SETUP_DELETE   = 'Admin Permanent Salary Delete';


}
