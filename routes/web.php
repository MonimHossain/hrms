<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// ajax api routes
// ajax process dropdown

use App\Employee;
use App\Events\LeaveApplyEvent;
use App\Mail\SendEmailMailable;
use App\Notifications\LeaveApply;
use App\Utils\Permissions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

//testing start
Route::get('event', function () {
    //   event(new LeaveApplyEvent('Hey, Leave apply event is working.'));
    //    \App\Employee::find(1)->userDetails->notify(new LeaveApply(\App\Leave::find(1)));
    Notification::send(auth()->user(), new LeaveApply(\App\Leave::find(1), 'Test', ' send a leave request.', 'leave.request'));
});

Route::get('listen', function () {
    return view('listenBroadcast');
});

Route::get('sendEmail', function () {
    Mail::to('ablaze.dip@gmail.com')->send(new SendEmailMailable(auth()->user()));
});
//testing end


Route::get('/process/process-segment/{id}', 'Admin\Employee\EmployeeController@getProcessSegment')->name('employee.get.processSegment');
Route::get('/division/center/{id}', 'Admin\Employee\EmployeeController@getCenter')->name('get.center');
Route::get('/division/center/department/{id}', 'Admin\Employee\EmployeeController@getDepartment')->name('get.department');
Route::get('/division/center/department/process/{id}', 'Admin\Employee\EmployeeController@getProcess')->name('get.process');
Route::get('/division/center/department/process/segment/{id}', 'Admin\Employee\EmployeeController@getProcessSegment')->name('get.processSegment');
Route::post('/default/division/center/', 'Admin\Employee\EmployeeController@setDefaultDivisionCenter')->name('set.default.center.division');

// get bank & branch
Route::get('/bank/{bank_id}', 'Admin\Payroll\ManageSalaryController@getBank')->name('get.bank');
Route::get('/bank/branch/{bank_id}', 'Admin\Payroll\ManageSalaryController@getBranch')->name('get.branch');
Route::get('/branch/{branch_id}', 'Admin\Payroll\ManageSalaryController@getBranchByBranchId')->name('get.branchByBranchId');


// institute suggestion ajax
Route::get('/find/institute/', 'HomeController@findInstitute')->name('find.institute');

// return login page
Route::get('/', function () {
    // return view('welcome');
    return redirect('login');
});

Route::get('/reset-password', function () {
    return view('auth.reset-password');
});

Auth::routes(['register' => false]);

//logs
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth');
Route::get('activity-log', function () {
    return \Spatie\Activitylog\Models\Activity::all()->last();
});

//Clear Cache facade value:
Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    //\Illuminate\Support\Facades\Artisan::call('route:cache');
    //\Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    return '<h1>Cache cleared</h1>';
});

// app download

Route::get('/app-download', 'AuthController@appDownload')->name('app-download');

// change password on very first login
Route::get('/password/change', 'HomeController@forcePasswordChange')->name('force-change-password');
Route::post('/password/change', 'HomeController@forcePasswordChangeSubmit');

// super admin password change
Route::get('/super-admin/change-password', 'Admin\Employee\EmployeeController@superAdminChangePasswordView')->middleware(['role:Super Admin'])->name('super.admin.change.password');
Route::post('/super-admin/change-password', 'Admin\Employee\EmployeeController@superAdminChangePassword')->middleware(['role:Super Admin']);

// set default division center
Route::get('settings/manage/defaults', 'Admin\Settings\ManagePermissionController@default')->name('settings.manage.default.division');

// notification
Route::get('/notification/read/{id}', 'NotificationController@markAsRead')->name('user.notification.markAsRead'); // mark specific notification as read
Route::get('/notification/read/all/{user}', 'NotificationController@markAllRead')->name('user.notification.markAllRead'); // mark all notification as read
Route::get('/notification/delete/all/{user}', 'NotificationController@deleteAll')->name('user.notification.deleteAll'); // delete all notification
Route::get('/permissions/sync', 'Admin\Employee\EmployeeController@syncPermission')->middleware(['permission:' . Permissions::ADMIN_PERMISSION_VIEW . '|' . Permissions::ADMIN_PERMISSION_CREATE])->name('sync.permission');
// admin routes
Route::group(['middleware' => 'role:Super Admin|Admin'], function () {

    Route::middleware(['admin_route_redirect', 'employment_status_check', 'first_login_change_password', 'default_division_center', 'impersonate'])->group(function () {
        Route::get('/home', 'HomeController@index')->name('home');

        // admin login main dashboard
        Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');


        // employee module
        Route::prefix('employee')->namespace('Admin\Employee')->group(function () {
            // impersonate start
            Route::get('/users/{id}/impersonate', 'EmployeeController@impersonate')->middleware('permission:' . Permissions::IMPERSONATE_VIEW)->name('impersonate');

            // switch division center
            Route::post('/switch/division/center', 'EmployeeController@switchDivisionCenter')->name('switch.division.center');
            // admin employee directory`
            Route::get('/', 'EmployeeController@index')->middleware(['permission:' . Permissions::EMPLOYEE_LIST_VIEW])->name('employee.list.view');
            Route::post('/info-state', 'EmployeeController@infoState')->middleware(['permission:' . Permissions::EMPLOYEE_LIST_VIEW])->name('info.state');
            Route::get('/inactive', 'EmployeeController@inactiveEmployee')->middleware(['permission:' . Permissions::EMPLOYEE_LIST_VIEW])->name('employee.inactive.list.view');
            Route::get('/untracked-employees', 'EmployeeController@unTrackedEmployee')->middleware(['permission:' . Permissions::EMPLOYEE_LIST_VIEW])->name('untracked.employee.list.view');
            Route::get('/untracked-list', 'EmployeeController@untrackedList')->middleware(['permission:' . Permissions::EMPLOYEE_LIST_VIEW])->name('employee.untracked.list');
            Route::get('/list', 'EmployeeController@anyData')->middleware(['permission:' . Permissions::EMPLOYEE_LIST_VIEW])->name('employee.list');
            Route::get('/list/inactive', 'EmployeeController@employeeInactiveData')->middleware(['permission:' . Permissions::EMPLOYEE_LIST_VIEW])->name('employee.list.inactive');
            Route::get('/profile/{id}', 'EmployeeController@employeeProfile')->middleware(['permission:' . Permissions::EMPLOYEE_PROFILE_VIEW])->name('employee.profile');
            Route::post('/profile/multi/division/center', 'EmployeeController@employeeMultiDivisionCenter')->middleware(['permission:' . Permissions::EMPLOYEE_PROFILE_VIEW])->name('employee.multi.division.center');
            Route::post('/permissions', 'EmployeeController@userPermission')->middleware(['permission:' . Permissions::ADMIN_PERMISSION_VIEW . '|' . Permissions::ADMIN_PERMISSION_CREATE])->name('employee.permissions');
            Route::get('/permissions/{id}', 'EmployeeController@employeePermissionsView')->middleware(['permission:' . Permissions::ADMIN_PERMISSION_VIEW . '|' . Permissions::ADMIN_PERMISSION_CREATE])->name('employee.permissions.view');
            Route::get('/permissions/{employee_id}/{division_id}/{center_id}', 'EmployeeController@employeePermissionsDetailsView')->middleware(['permission:' . Permissions::ADMIN_PERMISSION_VIEW . '|' . Permissions::ADMIN_PERMISSION_CREATE])->name('employee.permissions.details.view');

            Route::post('/permissions/submit', 'EmployeeController@employeePermissionSubmit')->middleware(['permission:' . Permissions::ADMIN_PERMISSION_VIEW . '|' . Permissions::ADMIN_PERMISSION_CREATE])->name('employee.permissions.submit');
            Route::get('/journey/{id}', 'EmployeeController@employeeJourney')->name('employee.journey');
            Route::get('/delete/employee/{id}', 'EmployeeController@deleteEmployee')->name('delete.employee');

            //Show all Employee show (kendo)
            Route::get('/all', 'EmployeeController@allList')->middleware(['permission:' . Permissions::EMPLOYEE_LIST_VIEW])->name('employee.all.list.view');
            Route::get('/all/list', 'EmployeeController@employeeJsonData')->middleware(['permission:' . Permissions::EMPLOYEE_LIST_VIEW])->name('employee.all.list');

            // employee login access
            Route::post('create/login/access', 'EmployeeController@loginAccess')->middleware(['permission:' . Permissions::EMPLOYEE_PROFILE_VIEW])->name('employee.loginAccess.create');

            // add new employee
            Route::get('/add/new', 'EmployeeController@addNewEmp')->middleware(['permission:' . Permissions::EMPLOYEE_CREATE])->name('employee.new.add.view'); // add new employee view
            Route::post('/check-id', 'EmployeeController@checkEmployerId')->middleware(['permission:' . Permissions::EMPLOYEE_CREATE])->name('check.id'); // check employer_id exists
            Route::post('/add/new/submit', 'EmployeeController@addNewEmpCreate')->middleware(['permission:' . Permissions::EMPLOYEE_CREATE])->name('employee.new.add.submit'); // add new employee submit form
            Route::get('/update/{id}', 'EmployeeController@updateEmpView')->middleware(['permission:' . Permissions::EMPLOYEE_EDIT])->name('employee.update.view'); // update employee view
            Route::post('/update/submit', 'EmployeeController@updateEmpSubmit')->middleware(['permission:' . Permissions::EMPLOYEE_EDIT])->name('employee.update.submit'); // update employee submit
            Route::get('/csv/upload', 'EmployeeController@bulkEmployeeUpload')->middleware(['permission:' . Permissions::EMPLOYEE_CREATE])->name('employee.bulk.upload.view'); // bulk employee upload view
            Route::post('/csv/upload', 'EmployeeController@bulkEmployeeUploadSubmit')->middleware(['permission:' . Permissions::EMPLOYEE_CREATE]); // bulk employee upload submit

            // employee export
            Route::get('/export', 'EmployeeController@exportDataView')->name('employee.export');
            Route::post('/export', 'EmployeeController@exportData');

            //Team Setup
            Route::get('/team', 'TeamController@team')->middleware(['permission:' . Permissions::ADMIN_TEAM_VIEW])->name('employee.team');
            Route::get('/employee-team', 'TeamController@employeeTeam')->middleware(['permission:' . Permissions::ADMIN_TEAM_VIEW])->name('employee.team.lists');
            Route::get('/team/list', 'TeamController@teamDataTable')->middleware(['permission:' . Permissions::ADMIN_TEAM_VIEW])->name('employee.team.list');
            Route::get('/team/index', 'TeamController@teamJsonData')->middleware(['permission:' . Permissions::ADMIN_TEAM_VIEW])->name('employee.team.index');
            Route::get('/team/create', 'TeamController@createTeam')->middleware(['permission:' . Permissions::ADMIN_TEAM_CREATE])->name('employee.team.create');
            Route::post('/team/save', 'TeamController@saveTeam')->middleware(['permission:' . Permissions::ADMIN_TEAM_CREATE])->name('employee.team.save');
            Route::post('/team/update', 'TeamController@updateTeam')->middleware(['permission:' . Permissions::ADMIN_TEAM_EDIT])->name('employee.team.update');
            Route::get('/team/list/{id}', 'TeamController@teamList')->middleware(['permission:' . Permissions::ADMIN_TEAM_VIEW])->name('employee.setting.team.list');
            Route::get('/team/edit/{id}', 'TeamController@teamEdit')->middleware(['permission:' . Permissions::ADMIN_TEAM_EDIT])->name('employee.setting.team.edit');
            Route::get('/team/delete/{id}', 'TeamController@teamDelete')->middleware(['permission:' . Permissions::ADMIN_TEAM_DELETE])->name('employee.setting.team.delete');
            Route::POST('/getAllSegment/team', 'TeamController@getAllSegment')->name('get.all.segment');
            Route::get('/team/member/create/{id}', 'TeamController@createTeamMember')->middleware(['permission:' . Permissions::ADMIN_TEAM_CREATE])->name('employee.team.member.create');
            Route::get('/team/member/remove/{employee}/{id}', 'TeamController@removeTeamMember')->middleware(['permission:' . Permissions::ADMIN_TEAM_DELETE])->name('employee.team.member.remove');
            Route::post('/team/member/save', 'TeamController@saveTeamMember')->middleware(['permission:' . Permissions::ADMIN_TEAM_CREATE])->name('employee.team.member.save');
            Route::post('/team/member/transfer', 'TeamController@transferTeamMember')->middleware(['permission:' . Permissions::ADMIN_TEAM_CREATE])->name('employee.team.treansfer');


            //hierarchy
            Route::get('/designation/hierarchy', 'HierarchyController@employeeWiseHierarchy')->middleware(['permission:' . Permissions::EMPLOYEE_LIST_VIEW])->name('employee.hierarchy');
            Route::get('/hierarchy', 'HierarchyController@designationWiseHierarchy')->middleware(['permission:' . Permissions::EMPLOYEE_LIST_VIEW])->name('designation.hierarchy');
            Route::get('/hierarchy/add/{id}', 'HierarchyController@employeeHierarchyAdd')->middleware(['permission:' . Permissions::EMPLOYEE_LIST_VIEW])->name('employee.hierarchy.add');
            Route::post('/hierarchy/save', 'HierarchyController@employeeHierarchySave')->middleware(['permission:' . Permissions::EMPLOYEE_LIST_VIEW])->name('employee.hierarchy.save');

            // attendance
            Route::get('/attendance/dashboard', 'AttendanceController@attendanceDashboard')->middleware(['permission:' . Permissions::ADMIN_ATTENDANCE_VIEW])->name('attendance.dashboard');
            Route::get('/attendance/leave/dashboard', 'AttendanceController@attendanceLeaveDashboardProcessWise')->middleware(['permission:' . Permissions::ADMIN_ATTENDANCE_VIEW])->name('process.attendance.leave.dashboard');
            Route::get('/attendance', 'AttendanceController@employeeAttendance')->middleware(['permission:' . Permissions::ADMIN_ATTENDANCE_VIEW])->name('employee.attendance.view');
            Route::get('/attendance/dept', 'AttendanceController@employeeDepartmentAttendance')->middleware(['permission:' . Permissions::ADMIN_ATTENDANCE_VIEW])->name('employee.dept.attendance.view');
            Route::get('/attendance/update', 'AttendanceController@updateAttendanceStatusView')->middleware(['permission:' . Permissions::ADMIN_ATTENDANCE_VIEW])->name('employee.dept.attendance.update.view');
            Route::post('/attendance/update', 'AttendanceController@updateAttendanceStatus')->middleware(['permission:' . Permissions::ADMIN_ATTENDANCE_VIEW])->name('employee.dept.attendance.craete.update.view');
            // ajax attendance modal info
            Route::post('/details', 'AttendanceController@attendanceDetails')->middleware(['permission:' . Permissions::ADMIN_ATTENDANCE_VIEW])->name('employee.attandance.details');

            Route::get('/attendance/change/approval/', 'AttendanceController@attendanceChangeApproval')->middleware(['permission:' . Permissions::ADMIN_ATTENDANCE_CREATE])->name('employee.attendance.change.approval');
            Route::post('/attendance/change/approval/', 'AttendanceController@attendanceChangeApprovalSubmit')->middleware(['permission:' . Permissions::ADMIN_ATTENDANCE_CREATE]);


            // employee ajax all for select2
            Route::get('/all/ajax', 'EmployeeController@employeeAll')->name('employee.all');
            Route::get('/all/employee/by/type', 'EmployeeController@employeeAllByType')->name('employee.all.by.type');
        });

        Route::any('/report', 'Admin\Employee\EmployeeController@reportView')->name('general.report');
        Route::any('/team-leave-report', 'Admin\Employee\EmployeeController@teamLeaveReportView')->name('Admin.Leave.team.report.view');



        // Excel File Uploader
        Route::get('/roster/upload', 'Admin\CsvUpload\CsvUploadController@index')->middleware(['permission:' . Permissions::ADMIN_ROSTER_VIEW])->name('roster.upload');
        Route::post('/roster/save', 'Admin\CsvUpload\CsvUploadController@saveRoster')->middleware(['permission:' . Permissions::ADMIN_ROSTER_CREATE])->name('roster.save');
        Route::get('/attendence/upload', 'Admin\CsvUpload\CsvUploadController@attendence')->middleware(['permission:' . Permissions::ADMIN_ATTENDANCE_VIEW])->name('attendence.upload');
        Route::post('/attendence/save', 'Admin\CsvUpload\CsvUploadController@importCsv')->middleware(['permission:' . Permissions::ADMIN_ATTENDANCE_CREATE])->name('attendence.save');


        // Previous attendance correction
        Route::get('/previous/attendance/correction', 'Admin\CsvUpload\CsvUploadController@previousAttendanceCorrectionList')->middleware(['permission:' . Permissions::ADMIN_ATTENDANCE_CREATE])->name('previous.attendance.correction.list');
        Route::get('/previous/attendance/correction/{id}/{emp}/{type}/view', 'Admin\CsvUpload\CsvUploadController@previousAttendanceCorrectionView')->middleware(['permission:' . Permissions::ADMIN_ATTENDANCE_CREATE])->name('previous.attendance.correction.view');
        Route::put('/previous/attendance/correction/{id}/update', 'Admin\CsvUpload\CsvUploadController@previousAttendanceCorrectionUpdate')->middleware(['permission:' . Permissions::ADMIN_ATTENDANCE_CREATE])->name('previous.attendance.correction.update');

        // Admin Leave
        Route::prefix('admin/report')->namespace('Admin\Report')->group(function () {
            Route::get('/employee', 'ReportController@employeeDataReport')->name('Admin.Report.employee-data');
            Route::get('/account-completion-report', 'ReportController@accountCompletion')->name('Admin.Report.account-completion');
            Route::get('/account-completion-report/{id}', 'ReportController@accountCompletionDetails')->name('Admin.Report.account-completion-details');
            Route::get('/account-completion-report/{id}/email', 'ReportController@accountCompletionEmail')->name('admin.report.account-completion-email-view');
            Route::post('/account-completion-report/{id}/email/send', 'ReportController@accountCompletionEmailSend')->name('admin.report.account-completion-email-send');
            Route::get('/missing-data-report', 'ReportController@missingDataReport')->name('Admin.Report.missing-data');
            Route::get('/now-at-office', 'ReportController@nowAtOffice')->name('Admin.Report.now-at-office');


        });


        // Admin Leave
        Route::prefix('admin/leave')->namespace('Admin\Leave')->group(function () {
            Route::get('/view/{id}/{approval_type?}/{approval_id?}', 'AdminLeaveController@leaveView')->middleware(['permission:' . Permissions::ADMIN_LEAVE_VIEW])->name('admin.leave.view');
            Route::get('/download/{id}/{approval_type?}/{approval_id?}', 'AdminLeaveController@leaveDownload')->middleware(['permission:' . Permissions::ADMIN_LEAVE_VIEW])->name('admin.leave.download');
            Route::get('/dashboard', 'AdminLeaveController@leaveDashboard')->middleware(['permission:' . Permissions::ADMIN_LEAVE_VIEW])->name('admin.leave.dashboard');
            Route::get('/report', 'AdminLeaveController@reportView')->middleware(['permission:' . Permissions::ADMIN_LEAVE_VIEW])->name('Admin.Leave.report.view');
            Route::any('/application', 'AdminLeaveController@adminLeaveApplication')->middleware(['permission:' . Permissions::ADMIN_LEAVE_VIEW])->name('admin.leave.application');
            Route::any('/application/details', 'AdminLeaveController@adminLeaveApplicationDetails')->middleware(['permission:' . Permissions::ADMIN_LEAVE_VIEW])->name('admin.leave.application.details');
            Route::any('/application/lwp', 'AdminLeaveController@adminLWPApplication')->middleware(['permission:' . Permissions::ADMIN_LEAVE_VIEW])->name('admin.leave.lwp.approvals');
            Route::get('/balance/update', 'AdminLeaveController@adminLeaveBalanceUpdate')->middleware(['permission:' . Permissions::ADMIN_LEAVE_CREATE])->name('admin.leave.balance.update');
            Route::post('/balance/update', 'AdminLeaveController@adminLeaveBalanceUpdateSubmit')->middleware(['permission:' . Permissions::ADMIN_LEAVE_CREATE]);
            Route::get('/balance/generate/yearly', 'AdminLeaveController@adminLeaveBalanceGenerateYearly')->middleware(['permission:' . Permissions::ADMIN_LEAVE_CREATE])->name('admin.leave.balance.generate.yearly');
            Route::post('/balance/generate/yearly', 'AdminLeaveController@adminLeaveBalanceGenerateYearlySubmit')->middleware(['permission:' . Permissions::ADMIN_LEAVE_CREATE]);
            Route::post('/application/apply', 'AdminLeaveController@adminLeaveApplyForEmployee')->middleware(['permission:' . Permissions::ADMIN_LEAVE_CREATE])->name('admin.employee.leave.apply');
            Route::post('/custom/generate', 'AdminLeaveController@adminCustomLeaveGenerate')->middleware(['permission:' . Permissions::ADMIN_LEAVE_CREATE])->name('admin.employee.custom.leave.generate');
            Route::get('/status', 'AdminLeaveController@adminLeaveStatus')->middleware(['permission:' . Permissions::ADMIN_LEAVE_VIEW])->name('admin.leave.status');
            Route::get('/details/{id?}', 'AdminLeaveController@leaveDetails')->middleware(['permission:' . Permissions::ADMIN_LEAVE_VIEW])->name('admin.leave.list');
            Route::post('/approval', 'AdminLeaveController@leaveApproval')->name('admin.leave.approval');
            Route::get('/delete/leave/{id}', 'AdminLeaveController@deleteLeave')->name('delete.leave');
        });



        //letter and document admin
        Route::prefix('admin/documents/letter')->namespace('Admin\LetterAndDocs')->group(function () {

            Route::get('/history', 'LetterAndDocController@documentHistory')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('admin.document.history');
            Route::get('/{id}/email', 'LetterAndDocController@SendDocumentToEmployeeByEmail')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('admin.document.email');

            Route::get('/template', 'LetterAndDocController@documentTemplate')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('admin.document.template');
            Route::post('/template/view', 'LetterAndDocController@viewDocumentTemplate')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('get.document.template');
            Route::post('save/template', 'LetterAndDocController@saveDocumentTemplate')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('save.document.template');
            Route::post('update/template', 'LetterAndDocController@updateDocumentTemplate')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_EDIT])->name('update.document.template');
            Route::post('change/status/template', 'LetterAndDocController@changeStatusDocumentTemplate')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_EDIT])->name('change.status.document.template');
            Route::get('/{id}/edit', 'LetterAndDocController@documentTemplateEdit')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_EDIT])->name('admin.document.template.edit');
            Route::post('/search/template', 'LetterAndDocController@documentTemplateSearch')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('admin.document.template.search');

            Route::get('/req/doc/setup', 'LetterAndDocController@requestDocumentSetupTemplate')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('admin.request.doc.setup');
            Route::get('/req/doc/setup/create', 'LetterAndDocController@requestDocumentSetupTemplateCreate')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('admin.request.doc.setup.create');
            Route::post('/req/doc/setup', 'LetterAndDocController@requestDocumentSetupTemplateStore')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('admin.request.doc.setup.store');
            Route::get('/req/doc/setup/{id}/edit', 'LetterAndDocController@requestDocumentSetupTemplateEdit')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_EDIT])->name('admin.request.doc.setup.edit');
            Route::PUT('/req/doc/setup/{id}', 'LetterAndDocController@requestDocumentSetupTemplateUpdate')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_EDIT])->name('admin.request.doc.setup.update');

            Route::get('/doc/header/template', 'LetterAndDocController@documentHeaderTemplate')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('admin.doc.header.template');
            Route::get('/doc/header/template/create', 'LetterAndDocController@documentHeaderTemplateCreate')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('admin.doc.header.template.create');
            Route::post('/doc/header/template', 'LetterAndDocController@documentHeaderTemplateStore')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('admin.doc.header.template.store');
            Route::get('/doc/header/template/{id}/show', 'LetterAndDocController@documentHeaderTemplateShow')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('admin.doc.header.template.show');
            Route::get('/doc/header/template/{id}/edit', 'LetterAndDocController@documentHeaderTemplateEdit')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_EDIT])->name('admin.doc.header.template.edit');
            Route::post('/doc/header/template/update', 'LetterAndDocController@documentHeaderTemplateUpdate')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_EDIT])->name('admin.doc.header.template.update');

            Route::post('/view/request/history', 'LetterAndDocController@documentRequestHistoryView')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('get.document.request.history.view');
            Route::post('/change/status/request/history', 'LetterAndDocController@documentRequestHistoryChangeStatus')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('change.status.document.request.history');

            Route::Post('/doc/name', 'LetterAndDocController@loadDocumentName')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('load.doc.name');
            Route::Post('/doc/content', 'LetterAndDocController@loadDocumentContent')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('load.doc.content');
            Route::Post('/doc/employee/information', 'LetterAndDocController@getDocEmployeeInformation')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('load.doc.employee.information');

            Route::get('/request/history', 'LetterAndDocController@documentRequestHistory')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('admin.document.request.history');

            Route::get('/create', 'LetterAndDocController@documentCreate')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('admin.document.create');

            Route::get('/doc/template/create', 'LetterAndDocController@documentTemplateCreate')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('admin.document.template.create');

            Route::POST('save/document', 'LetterAndDocController@adminSaveDocument')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('admin.document.save');

            Route::POST('/query/data', 'LetterAndDocController@getAllDocumentQueryData')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('document.query.data');
            Route::POST('/doc/type/page', 'LetterAndDocController@loadPageByDocType')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('load.doc.type.page');
            Route::get('generate-pdf', 'LetterAndDocController@generatePDF')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('admin.generate-pdf');
            Route::get('generate/letter-docs', 'LetterAndDocController@generateAndViewModal')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('letter.and.documents');

            Route::get('generate/letter-docs/{id}/pdf/{type}', 'LetterAndDocController@documentAndLetterWithPdf')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('letter.and.documents.pdf');
            Route::POST('generate/letter-docs/status', 'LetterAndDocController@documentAndLetterChangeStatus')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('letter.and.documents.status');

            Route::get('admin/letter-docs/report', 'LetterAndDocController@documentAndLetterReport')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('admin.letter.document.report');

            /*Route::POST('generate/letter-docs/word','LetterAndDocController@saveDocumentAndLetterWithWord')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('save.letter.and.documents.word');
            Route::POST('generate/letter-docs/email','LetterAndDocController@saveDocumentAndLetterWithEmail')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('save.letter.and.documents.email');
            Route::POST('generate/letter-docs/print','LetterAndDocController@saveDocumentAndLetterWithPrint')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE])->name('save.letter.and.documents.print');*/
        });


        //letter and document admin
        Route::prefix('admin')->namespace('Admin')->group(function () {
            /* Hiring Requitment */
            Route::get('/request/history', 'HiringRecruitmentController@hiringRequestHistory')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('admin.hiring.request.history');
            Route::get('/request/create', 'HiringRecruitmentController@hiringRequestCreate')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('admin.hiring.request.new');
            Route::post('/request/store', 'HiringRecruitmentController@hiringRequestStore')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('admin.hiring.request.store');
            Route::get('/request/{id}/view', 'HiringRecruitmentController@hiringRequestView')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('admin.hiring.request.view');
            Route::get('/request/{id}/edit', 'HiringRecruitmentController@hiringRequestEdit')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('admin.hiring.request.edit');
            Route::put('/request/{id}/update', 'HiringRecruitmentController@hiringRequestUpdate')->middleware(['permission:' . Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW])->name('admin.hiring.request.update');

        });


        //Admin event and notice
        Route::prefix('admin/notices')->namespace('Admin\NoticeAndEvent')->group(function () {
            Route::get('/new/notice', 'NoticeEventControllers@newNoticeEvent')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_VIEW])->name('admin.new.notice.event');
            Route::post('/new/notice', 'NoticeEventControllers@saveNoticeEvent')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_CREATE])->name('admin.save.notice.event');
            Route::post('/update/notice', 'NoticeEventControllers@updateNoticeEvent')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_CREATE])->name('admin.update.notice.event');
            Route::post('/load/process/segment/list', 'NoticeEventControllers@loadProcessSegmentList')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_VIEW])->name('admin.notices.load.process.segment');

            Route::get('{id}/details', 'NoticeEventControllers@showNoticeEvent')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_VIEW])->name('show.notices.event');
            Route::get('{id}/edit', 'NoticeEventControllers@editNoticeEvent')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_CREATE])->name('edit.notices.event');

            Route::get('/notice/board', 'NoticeEventControllers@noticeBoard')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_VIEW])->name('admin.notice.board');
            Route::get('/event/calender', 'NoticeEventControllers@eventCalender')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_VIEW])->name('admin.event.calender');
            //Route::get('/status/')
        });


        //Admin Appraisal
        Route::prefix('admin/appraisal')->namespace('Admin\Appraisal')->group(function () {
            Route::get('/question/setup/new', 'AppraisalControllers@questionSetupNew')->middleware(['permission:' . Permissions::APPRAISAL_SETTING_CREATE])->name('appraisal.question.setup.new');
            Route::post('/question/filter/list', 'AppraisalControllers@questionFilterList')->name('appraisal.question.filter.list');
            Route::get('/question/setup/list', 'AppraisalControllers@questionSetupList')->middleware(['permission:' . Permissions::APPRAISAL_SETTING_VIEW])->name('appraisal.question.setup.list');
            Route::post('/question/setup/store', 'AppraisalControllers@questionSetupSave')->name('appraisal.question.setup.save');
            Route::get('/question/setup/{id}/edit', 'AppraisalControllers@questionSetupEdit')->middleware(['permission:' . Permissions::APPRAISAL_SETTING_EDIT])->name('appraisal.question.setup.edit');
            Route::put('/question/setup/{id}/update', 'AppraisalControllers@questionSetupUpdate')->name('appraisal.question.setup.update');
            Route::put('/question/setup/{id}/delete', 'AppraisalControllers@questionSetupDelete')->middleware(['permission:' . Permissions::APPRAISAL_SETTING_DELETE])->name('appraisal.question.setup.delete');

            Route::get('/view/answer/list/details/{id}', 'AppraisalControllers@answerListDetails')->name('appraisal.answer.list.view');


            Route::get('/history/new', 'AppraisalControllers@appraisalHistoryList')->middleware(['permission:' . Permissions::APPRAISAL_APPRAISAL_VIEW])->name('appraisal.history.list');
            Route::get('/log/list', 'AppraisalControllers@appraisalLogList')->middleware(['permission:' . Permissions::APPRAISAL_APPRAISAL_VIEW])->name('appraisal.log.list');
            Route::get('/log/new', 'AppraisalControllers@appraisalLogNew')->middleware(['permission:' . Permissions::APPRAISAL_APPRAISAL_CREATE])->name('appraisal.log.new');
            Route::get('/detail/{id}/log', 'AppraisalControllers@detailLog')->middleware(['permission:' . Permissions::APPRAISAL_APPRAISAL_VIEW])->name('appraisal.history.detail.log');

            Route::get('/history/{id}/generate', 'AppraisalControllers@appraisalGenerate')->middleware(['permission:' . Permissions::APPRAISAL_APPRAISAL_CREATE])->name('appraisal.generate');
            Route::get('/history/{id}/regenerate/{year}', 'AppraisalControllers@appraisalReGenerate')->middleware(['permission:' . Permissions::APPRAISAL_APPRAISAL_CREATE])->name('appraisal.regenerate');

            Route::get('/evaluation/history/new', 'AppraisalControllers@evaluationHistoryList')->middleware(['permission:' . Permissions::APPRAISAL_EVALUATION_VIEW])->name('evaluation.history.list');
            Route::get('/evaluation/history/{id}/employee', 'AppraisalControllers@evaluationHistoryEmployeeView')->middleware(['permission:' . Permissions::APPRAISAL_EVALUATION_VIEW])->name('evaluation.employee.view');
            Route::get('/employee/evaluation/name/{id}/edit', 'AppraisalControllers@employeeEvaluationNameEdit')->middleware(['permission:' . Permissions::APPRAISAL_EVALUATION_EDIT])->name('employee.evaluation.name.edit');
            Route::put('/employee/evaluation/name/{id}/update', 'AppraisalControllers@employeeEvaluationNameUpdate')->middleware(['permission:' . Permissions::APPRAISAL_EVALUATION_EDIT])->name('employee.evaluation.name.update');
            Route::get('/evaluation/log/list', 'AppraisalControllers@evaluationLogList')->middleware(['permission:' . Permissions::APPRAISAL_EVALUATION_VIEW])->name('evaluation.log.list');
            Route::get('/evaluation/log/new', 'AppraisalControllers@evaluationLogNew')->middleware(['permission:' . Permissions::APPRAISAL_EVALUATION_CREATE])->name('evaluation.log.new');
            Route::post('/evaluation/log/save', 'AppraisalControllers@evaluationLogSave')->middleware(['permission:' . Permissions::APPRAISAL_EVALUATION_CREATE])->name('evaluation.log.save');

            /*Department wise Analytical Report*/
            Route::get('department/wise/evaluation/analytical/report/', 'AppraisalControllers@evaluationAnalyticalReport')->middleware(['permission:' . Permissions::APPRAISAL_REPORT_VIEW])->name('user.evaluation.analytical.report');
            Route::get('department/wise/evaluation/analytical/employee/view/by/{year}/{evaluation}/{department}/{recommend}', 'AppraisalControllers@evaluationAnalyticalReportForEmployeeView')->middleware(['permission:' . Permissions::APPRAISAL_REPORT_VIEW])->name('evaluation.analytic.employee.view');
            /*Route::get('department/wise/evaluation/analytical/employee/view/by/{id}/details','AppraisalControllers@evaluationAnalyticalReportForEmployeeViewDetails')->name('evaluation.analytic.employee.view.details');*/

            /*Team wise Analytical Report*/
            Route::get('team/wise/evaluation/analytical/report', 'AppraisalControllers@evaluationAnalyticalReportTeam')->middleware(['permission:' . Permissions::APPRAISAL_REPORT_VIEW])->name('user.evaluation.analytical.report.team');
            /*Route::get('team/wise/evaluation/analytical/employee/view/by/{year}/{evaluation}/{department}/{recommend}','AppraisalControllers@evaluationAnalyticalReportForEmployeeViewTeam')->name('evaluation.analytic.employee.view.team');
            Route::get('team/wise/evaluation/analytical/employee/view/by/{id}/details','AppraisalControllers@evaluationAnalyticalReportForEmployeeViewDetailsTeam')->name('evaluation.analytic.employee.view.details.team');*/

            /*Employee wise Analytical Report*/
            Route::get('employee/wise/evaluation/analytical/report', 'AppraisalControllers@evaluationAnalyticalReportEmployee')->middleware(['permission:' . Permissions::APPRAISAL_REPORT_VIEW])->name('user.evaluation.analytical.report.employee');
            /*Route::get('employee/wise/evaluation/analytical/employee/view/by/{year}/{evaluation}/{department}/{recommend}','AppraisalControllers@evaluationAnalyticalReportForEmployeeViewEmployee')->name('evaluation.analytic.employee.view.employee');
            Route::get('employee/wappraisal/setting/question/createise/evaluation/analytical/employee/view/by/{id}/details','AppraisalControllers@evaluationAnalyticalReportForEmployeeViewDetailsEmployee')->name('evaluation.analytic.employee.view.details.employee');*/


            Route::get('/evaluation/lead/evaluation/status', 'AppraisalControllers@adminLeadEvaluationStatus')->name('admin.lead.evaluation.status');
            Route::get('/evaluation/history/{id}/lead', 'AppraisalControllers@evaluationHistoryLeadView')->name('evaluation.lead.view');
            Route::get('/lead/evaluation/name/{id}/edit', 'AppraisalControllers@leadEvaluationNameEdit')->name('lead.evaluation.name.edit');
            Route::put('/lead/evaluation/name/{id}/update', 'AppraisalControllers@leadEvaluationNameUpdate')->name('lead.evaluation.name.update');

            /*KPI Percentage*/
            Route::get('/kpi/percentage/list', 'AppraisalControllers@kpiPercentageList')->middleware(['permission:' . Permissions::APPRAISAL_SETTING_VIEW])->name('kpi.percentage.list');
            Route::get('/kpi/percentage/add', 'AppraisalControllers@kpiPercentageAdd')->middleware(['permission:' . Permissions::APPRAISAL_SETTING_VIEW])->name('kpi.percentage.add');
            Route::get('/kpi/percentage/{id}/edit', 'AppraisalControllers@kpiPercentageEdit')->middleware(['permission:' . Permissions::APPRAISAL_SETTING_VIEW])->name('kpi.percentage.edit');
            Route::put('/kpi/percentage/{id}/update', 'AppraisalControllers@kpiPercentageUpdate')->middleware(['permission:' . Permissions::APPRAISAL_SETTING_VIEW])->name('kpi.percentage.update');
        });


        //Admin Closing
        Route::prefix('admin/employee/closing')->namespace('Admin\EmployeeClosing')->group(function () {
            /*Route::get('/request/accounts', 'EmployeeClosingControllers@account')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_VIEW])->name('request.clearance.account');
            Route::get('/accounts/approval/{id}/{appId}/show', 'EmployeeClosingControllers@accountShow')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_VIEW])->name('request.clearance.account.show');
            Route::put('/accounts/approval/{id}/approved', 'EmployeeClosingControllers@accountApproved')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_VIEW])->name('request.clearance.account.approved');


            Route::get('/request/it', 'EmployeeClosingControllers@it')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_CREATE])->name('request.clearance.it');
            Route::get('/it/approval/{id}/show', 'EmployeeClosingControllers@itShow')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_VIEW])->name('request.clearance.it.show');
            Route::put('/it/approval/{id}/approved', 'EmployeeClosingControllers@itApproved')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_VIEW])->name('request.clearance.it.approved');


            Route::get('/request/admin', 'EmployeeClosingControllers@admin')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_CREATE])->name('request.clearance.admin');
            Route::get('/admin/approval/{id}/show', 'EmployeeClosingControllers@adminShow')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_VIEW])->name('request.clearance.admin.show');
            Route::put('/admin/approval/{id}/approved', 'EmployeeClosingControllers@adminApproved')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_VIEW])->name('request.clearance.admin.approved');


            Route::get('/request/hr', 'EmployeeClosingControllers@hr')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_VIEW])->name('request.clearance.hr');
            Route::get('/hr/approval/{id}/show', 'EmployeeClosingControllers@hrShow')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_VIEW])->name('request.clearance.hr.show');
            Route::put('/hr/approval/{id}/approved', 'EmployeeClosingControllers@hrApproved')->middleware(['permission:' . Permissions::ADMIN_NOTICE_AND_EVENT_VIEW])->name('request.clearance.hr.approved');*/
        });


        //Admin Clearance Checklist
        Route::prefix('admin/employee/closing')->namespace('Admin\EmployeeClosing')->group(function () {
            /*Start employee termination*/
            Route::get('dashboard', 'EmployeeClosingChecklistController@dashboard')->middleware(['permission:' . Permissions::EMPLOYEE_CLOSING_SEPARATION_VIEW])->name('admin.closing.dashboard');
            Route::get('termination', 'EmployeeClosingChecklistController@employeeTermination')->middleware(['permission:' . Permissions::EMPLOYEE_CLOSING_SEPARATION_VIEW])->name('admin.employee.termination');
            Route::get('termination/create', 'EmployeeClosingChecklistController@employeeTerminationCreate')->middleware(['permission:' . Permissions::EMPLOYEE_CLOSING_SEPARATION_CREATE])->name('admin.employee.termination.create');
            Route::post('termination/store', 'EmployeeClosingChecklistController@employeeTerminationStore')->middleware(['permission:' . Permissions::EMPLOYEE_CLOSING_SEPARATION_CREATE])->name('admin.employee.termination.store');
            Route::get('termination/{id}/view', 'EmployeeClosingChecklistController@employeeTerminationView')->middleware(['permission:' . Permissions::EMPLOYEE_CLOSING_SEPARATION_VIEW])->name('admin.employee.termination.view');
            /*End employee termination*/


            Route::get('/{id}/list', 'EmployeeClosingChecklistController@index')->middleware(['permission:' . Permissions::EMPLOYEE_CLOSING_SETTING_VIEW])->name('admin.clearance.checklist');


            Route::put('/{id}/update', 'EmployeeClosingChecklistController@update')->middleware(['permission:' . Permissions::EMPLOYEE_CLOSING_SETTING_VIEW])->name('admin.clearance.checklist.update');


            Route::get('list', 'EmployeeClosingChecklistController@list')->middleware(['permission:' . Permissions::EMPLOYEE_CLOSING_SETTING_VIEW])->name('admin.clearance.checklist.list');
            Route::get('export', 'EmployeeClosingChecklistController@exportCsv')->middleware(['permission:' . Permissions::EMPLOYEE_CLOSING_SETTING_VIEW])->name('admin.clearance.checklist.export');

            Route::get('attrition/report', 'EmployeeClosingChecklistController@attritionReport')->middleware(['permission:' . Permissions::EMPLOYEE_CLOSING_REPORT_VIEW])->name('admin.closing.attrition.report');
            Route::get('status/report', 'EmployeeClosingChecklistController@clearanceStatus')->middleware(['permission:' . Permissions::EMPLOYEE_CLOSING_REPORT_VIEW])->name('admin.clearance.status.report');
            Route::get('fnf/report/show', 'EmployeeClosingChecklistController@adminFnfReport')->middleware(['permission:' . Permissions::EMPLOYEE_CLOSING_REPORT_VIEW])->name('admin.fnf.report');
            Route::get('fnf/report/export', 'EmployeeClosingChecklistController@adminFnfExport')->middleware(['permission:' . Permissions::EMPLOYEE_CLOSING_REPORT_VIEW])->name('admin.fnf.report.export');
        });


        // app settings
        Route::prefix('settings/manage')->namespace('Admin\Settings')->group(function () {
            // Role
            Route::get('/role', 'ManageRoleController@index')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('settings.manage.role.view');
            Route::get('/role/add/new', 'ManageRoleController@addNewRoleView')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('settings.manage.role.add.view');
            Route::post('/role/add', 'ManageRoleController@create')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('settings.manage.role.add');
            Route::post('/role/assign/permission', 'ManageRoleController@assignPermission')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('settings.manage.role.assignPermission');

            // Permission

            Route::get('/permission', 'ManagePermissionController@index')->middleware(['permission:' . Permissions::ADMIN_PERMISSION_VIEW])->name('settings.manage.permission.view');
            Route::post('/permission/add', 'ManagePermissionController@create')->middleware(['permission:' . Permissions::ADMIN_PERMISSION_CREATE])->name('settings.manage.permission.add');

            //setting lookup data
            Route::get('/division', 'LookupController@division')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_VIEW])->name('settings.manage.division');
            Route::post('/division', 'LookupController@divisionCreate')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE])->name('settings.manage.division.create');
            Route::get('/division/edit/{id}', 'LookupController@divisionEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.division.edit');
            Route::put('/division/update/{id}', 'LookupController@divisionEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.division.update');

            Route::get('/department', 'LookupController@department')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_VIEW])->name('settings.manage.department');
            Route::post('/department', 'LookupController@departmentCreate')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE])->name('settings.manage.department.create');
            Route::get('/department/edit/{id}', 'LookupController@departmentEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.department.edit');
            Route::put('/department/update/{id}', 'LookupController@departmentEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.department.update');

            Route::get('/lookup/setup/delete/{id}/{model}/{redirect}/{getRouteId?}', 'LookupController@lookupSetupDelete')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.delete');

            Route::get('/designation', 'LookupController@designation')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_VIEW])->name('settings.manage.designation');
            Route::post('/designation', 'LookupController@designationCreate')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE])->name('settings.manage.designation.create');
            Route::get('/designation/edit/{id}', 'LookupController@designationEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.designation.edit');
            Route::put('/designation/update/{id}', 'LookupController@designationEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.designation.update');


            Route::get('/process', 'LookupController@process')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_VIEW])->name('settings.manage.process');
            Route::post('/process', 'LookupController@processCreate')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE])->name('settings.manage.process.create');
            Route::get('/process/edit/{id}', 'LookupController@processEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.process.edit');
            Route::put('/process/update/{id}', 'LookupController@processEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.process.update');
            Route::get('/process/{id}/add/department', 'LookupController@addDepartmentToProcess')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.process.add.department');
            Route::put('/process/{id}/update/department', 'LookupController@updateDepartmentToProcess')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.process.update.department');

            Route::get('/process/segment', 'LookupController@processSegment')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_VIEW])->name('settings.manage.process.segment');
            Route::post('/process/segment', 'LookupController@processSegmentCreate')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE])->name('settings.manage.process.segment.create');
            Route::get('/process/segment/edit/{id}', 'LookupController@processSegmentEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.process.segment.edit');
            Route::put('/process/segment/update/{id}', 'LookupController@processSegmentEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.process.segment.update');


            // leave reason lookup table
            Route::get('/leave/reason', 'LookupController@leaveReason')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_VIEW])->name('settings.manage.leave.reason');
            Route::post('/leave/reason', 'LookupController@leaveReasonCreate')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE]);
            Route::get('/leave/reason/edit/{id}', 'LookupController@leaveReasonEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.leave.reason.edit');
            Route::put('/leave/reason/update/{id}', 'LookupController@leaveReasonEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.leave.reason.update');


            Route::get('/process/employee/status', 'LookupController@status')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_VIEW])->name('settings.manage.employee.status');
            Route::post('/process/employee/status', 'LookupController@statusCreate')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE])->name('settings.manage.employee.status.create');
            Route::get('/process/employee/status/edit/{id}', 'LookupController@statusEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.process.employee.status.edit');
            Route::put('/process/employee/status/update/{id}', 'LookupController@statusEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.process.employee.status.update');

            Route::get('/center', 'LookupController@center')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_VIEW])->name('settings.manage.center');
            Route::post('/center/create', 'LookupController@centerCreate')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE])->name('settings.manage.center.create');
            Route::get('/center/edit/{id}', 'LookupController@centerEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.center.edit');
            Route::put('/center/update/{id}', 'LookupController@centerEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.center.update');
            Route::get('/center/{id}/add/department', 'LookupController@addDepartmentToCenter')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.center.add.department');
            Route::put('/center/{id}/update/department', 'LookupController@updateDepartmentToCenter')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.center.update.department');

            //setup letter and document
            Route::get('/document', 'LookupController@setupDoc')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_VIEW])->name('settings.manage.document');
            Route::post('/document/create', 'LookupController@docCreate')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE])->name('settings.manage.document.create');
            Route::get('/document/edit/{id}', 'LookupController@docEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.document.edit');
            Route::put('/document/update/{id}', 'LookupController@docEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.document.update');

            Route::get('/roster', 'LookupController@roster')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_VIEW])->name('settings.manage.roster');
            Route::post('/roster/create', 'LookupController@rosterCreate')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE])->name('settings.manage.roster.create');
            Route::get('/roster/edit/{id}', 'LookupController@rosterEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.roster.edit');
            Route::put('/roster/update/{id}', 'LookupController@rosterEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.roster.update');

            Route::get('/setup/leave', 'LookupController@leave')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_VIEW])->name('settings.manage.set.leave');
            Route::post('/setup/leave/create', 'LookupController@leaveCreate')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE])->name('settings.manage.set.leave.create');
            Route::get('/setup/leave/edit/{id}', 'LookupController@leaveEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.set.leave.edit');
            Route::put('/setup/leave/update/{id}', 'LookupController@leaveEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.set.leave.update');


            //Workflow Setup
            Route::get('/workflow/setup', 'WorkflowController@index')->middleware(['permission:' . Permissions::ADMIN_WORKFLOW_SETTINGS_VIEW])->name('settings.workflow.base.setup');
            Route::get('/workflow/process/workflow/{id}', 'WorkflowController@getAllProcessByWorkflowId');
            Route::get('/workflow/process/add/{id}', 'WorkflowController@getAddProcessToWorkflow');
            Route::post('/workflow/process/save', 'WorkflowController@saveProcessWorkflow')->middleware(['permission:' . Permissions::ADMIN_WORKFLOW_SETTINGS_CREATE])->name('workflow.process.save');
            Route::get('/workflow/approval/hierarchy/{id}/{team}', 'WorkflowController@approvalHierarchy')->name('workflow.approval.hierarchy');
            Route::post('/process/ordering/save', 'WorkflowController@processOrderingSave')->name('process.ordering.save');


            Route::get('/institutes', 'LookupController@institute')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_VIEW])->name('settings.manage.institutes');
            Route::post('/institutes/create', 'LookupController@instituteCreate')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE])->name('settings.manage.institutes.create');
            Route::get('/institutes/edit/{id}', 'LookupController@instituteEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.institutes.edit');
            Route::put('/institutes/update/{id}', 'LookupController@instituteEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.institutes.update');

            Route::get('/holidays', 'LookupController@holiday')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_VIEW])->name('settings.manage.holidays');
            Route::post('/holidays/create', 'LookupController@holidayCreate')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE])->name('settings.manage.holidays.create');
            Route::get('/holidays/edit/{id}', 'LookupController@holidayEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.holidays.edit');
            Route::put('/holidays/update/{id}', 'LookupController@holidayEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.holidays.update');
            Route::post('/holidays/center/create', 'LookupController@holidayCenterCreate')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE])->name('settings.manage.holidays.center.create');
            Route::post('/holidays/center/checked', 'LookupController@holidayCenterChecked')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE])->name('settings.manage.holidays.center.checked');

            Route::get('/nearbyLocations', 'LookupController@nearbyLocation')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_VIEW])->name('settings.manage.nearbyLocations');
            Route::post('/nearbyLocations/create', 'LookupController@nearbyLocationCreate')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_CREATE])->name('settings.manage.nearbyLocations.create');
            Route::get('/nearbyLocations/edit/{id}', 'LookupController@nearbyLocationEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.nearbyLocations.edit');
            Route::put('/nearbyLocations/update/{id}', 'LookupController@nearbyLocationEdit')->middleware(['permission:' . Permissions::ADMIN_GENERAL_SETTINGS_EDIT])->name('settings.manage.nearbyLocations.update');
        });



        //Admin Payroll
        Route::prefix('payroll/kpi')->namespace('Admin\Payroll')->group(function () {
            //Admin KPI
            Route::get('/settings', 'KpiController@index')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('kpi.setting.index');
            Route::get('/upload', 'KpiController@create')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('kpi.setting.create');
            Route::get('/settings/add', 'KpiController@add')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('kpi.setting.add');
            Route::post('/settings/save', 'KpiController@save')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('kpi.setting.save');
            Route::post('/settings', 'KpiController@store')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('kpi.setting.store');
            Route::get('/settings/{id}', 'KpiController@show')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('kpi.setting.show');
            Route::get('/settings/{id}/edit', 'KpiController@edit')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('kpi.setting.edit');
            Route::put('/settings/{id}', 'KpiController@update')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('kpi.setting.update');
            Route::delete('/settings/{id}', 'KpiController@destroy')->middleware(['permission:' . Permissions::ADMIN_ROLE_DELETE])->name('kpi.setting.destroy');
        });

        //admin loan
        Route::prefix('loan')->namespace('Admin\Loan')->group(function () {

            /*Loan Api start*/
            Route::GET('show/api/{flag?}/{id?}', 'LoanApplicationController@showLoanApi')->name('show.loan.api');
            /*Loan Api end*/

            Route::GET('applications/history', 'LoanApplicationController@applicationHistory')->name('admin.loan.application.history');
            Route::GET('applications/history/{id}/update', 'LoanApplicationController@applicationHistoryUpdate')->name('admin.loan.application.history.edit');
            Route::PUT('applications/history/{id}/update', 'LoanApplicationController@applicationHistoryChangeUpdate')->name('admin.loan.application.history.update');
            Route::GET('status/history', 'LoanApplicationController@loanStatusHistory')->name('admin.loan.status.history');
            Route::GET('statement/update', 'LoanApplicationController@loanStatementUpdate')->name('admin.loan.statement.update');
            Route::GET('statement/{id}/emi/', 'LoanApplicationController@loanStatementEmiChange')->name('admin.loan.statement.emi.change');
            Route::PUT('statement/update/{id}/emi/', 'LoanApplicationController@loanStatementUpdateEmiChange')->name('admin.loan.statement.update.emi.change');
            Route::GET('statement/generate/emi/all', 'LoanApplicationController@loanStatementUpdateEmiGenerate')->name('admin.loan.statement.update.emi.generate');
            Route::GET('statement/generate/emi/clearance', 'LoanApplicationController@loanStatementUpdateEmiClearance')->name('admin.loan.statement.update.emi.clearance');

            Route::GET('statement/history', 'LoanApplicationController@loanStatementHistory')->name('admin.loan.statement.history');
            Route::GET('emi/application/history', 'LoanApplicationController@emiApplicationHistory')->name('admin.loan.emi.application.history');
            Route::GET('emi/application/history/{id}/edit', 'LoanApplicationController@emiApplicationHistoryEdit')->name('admin.loan.emi.application.history.edit');
            Route::PUT('emi/application/history/{id}/edit', 'LoanApplicationController@emiApplicationHistoryUpdate')->name('admin.loan.emi.application.history.update');
            Route::GET('setting/loan/type', 'LoanApplicationController@settingLoanType')->name('admin.loan.setting.loan.type');
            Route::GET('setting/loan/{id}/interested', 'LoanApplicationController@settingLoanInterested')->name('admin.loan.setting.loan.interested');

            Route::GET('setting/loan/type/create', 'LoanApplicationController@settingLoanTypeCreate')->name('admin.loan.setting.loan.create');
            Route::POST('setting/loan/type/save', 'LoanApplicationController@settingLoanTypeSave')->name('admin.loan.setting.loan.save');
            Route::get('setting/loan/type/{id}/edit', 'LoanApplicationController@settingLoanTypeEdit')->name('admin.loan.setting.loan.edit');
            Route::PATCH('setting/loan/type/{id}/update', 'LoanApplicationController@settingLoanTypeUpdate')->name('admin.loan.setting.type.update');
            Route::PATCH('setting/loan/interested/{id}/update', 'LoanApplicationController@settingLoanInterestedUpdate')->name('admin.loan.setting.interested.update');


            Route::GET('applications/create', 'LoanApplicationController@create')->name('loam.application.create');
            Route::POST('applications', 'LoanApplicationController@store')->name('loam.application.store');
            Route::GET('applications/{id}', 'LoanApplicationController@show')->name('loam.application.show');
            Route::GET('applications/{id}/edit', 'LoanApplicationController@edit')->name('loam.application.edit');
            Route::PATCH('applications/{id}', 'LoanApplicationController@update')->name('loam.application.update');
            Route::DELETE('applications/{id}', 'LoanApplicationController@destroy')->name('loam.application.destroy');
        });

        Route::prefix('resource')->namespace('Admin')->group(function () {
            Route::get('library', 'ResourceLibController@library')->name('resource.list');
            Route::get('trash', 'ResourceLibController@trash')->name('resource.trashes');
            Route::get('library/add', 'ResourceLibController@addLibrary')->name('resource.create');
            Route::post('library', 'ResourceLibController@insertLibrary')->name('resource.insert');
            Route::get('/library/edit/{id}', 'ResourceLibController@editLibrary')->name('resource.edit');
            Route::get('/library/trash/{id}', 'ResourceLibController@trashLibrary')->name('resource.trash');
            Route::get('/library/restore/{id}', 'ResourceLibController@restoreLibrary')->name('resource.restore');
            Route::get('/library/delete/{id}', 'ResourceLibController@deleteLibrary')->name('resource.delete');
            Route::post('/library/update', 'ResourceLibController@updateLibrary')->name('resource.update');
        });

        Route::prefix('asset')->namespace('Admin\Asset')->group(function () {
            Route::get('types', 'AssetController@types')->name('add.new.type');
            Route::post('types', 'AssetController@typeCreate')->name('create.new.type');
            Route::get('/types/edit/{id}', 'AssetController@typeEdit')->name('asset.types.edit');
            Route::post('/types/update/{id}', 'AssetController@typeEdit')->name('asset.types.update');

            Route::get('/allocaiton', 'AssetController@allocaiton')->name('asset.allocaiton');
            Route::post('/allocation/create', 'AssetController@allocation_store')->name('asset.allocation.create');
            Route::get('/allocation/add', 'AssetController@allocation_add')->name('asset.allocation.add');
            Route::get('/allocation/{id}/edit', 'AssetController@allocation_edit')->name('asset.allocation.edit');
            Route::get('/allocation/{id}/view', 'AssetController@allocation_view')->name('asset.allocation.view');
            Route::put('/allocation/{id}/update', 'AssetController@allocation_update')->name('asset.allocation.update');

            Route::get('/list', 'AssetController@index')->name('asset.index');
            Route::get('/my-assets', 'AssetController@myAssets')->name('myAsset.index');
            Route::post('/create', 'AssetController@store')->name('asset.create');
            Route::get('/add', 'AssetController@add')->name('asset.add');
            Route::get('/{id}/edit', 'AssetController@edit')->name('asset.edit');
            Route::get('/{id}/view', 'AssetController@view')->name('asset.view');
            Route::put('/{id}/update', 'AssetController@update')->name('asset.update');

            Route::get('/requisitions', 'AssetController@requisition')->name('asset.requisition');
            Route::get('/my-requisitions', 'AssetController@myRequisition')->name('asset.my.requisition');
            Route::get('delete/my-requisitions/{id}', 'AssetController@deleteMyRequisition')->name('asset.requisition.delete');
            Route::post('/requisition/create', 'AssetController@requisition_store')->name('asset.requisition.create');
            Route::get('/requisition/add', 'AssetController@requisition_add')->name('asset.requisition.add');
            Route::get('/requisition/{id}/edit', 'AssetController@requisition_edit')->name('asset.requisition.edit');
            Route::get('/requisition/{id}/view', 'AssetController@requisition_view')->name('asset.requisition.view');
            Route::put('/requisition/{id}/update', 'AssetController@requisition_update')->name('asset.requisition.update');

            Route::get('/setting', 'AssetController@setting')->name('asset.setting');
            Route::put('/setting/{id}/update', 'AssetController@settingUpdate')->name('asset.setting.update');
        });

        Route::prefix('payroll')->namespace('Admin\Payroll')->group(function () {
            // manage Bank
            Route::get('add/new/bank', 'ManageSalaryController@addNewBank')->name('add.new.bank');
            Route::post('add/new/bank/submit', 'ManageSalaryController@addNewBankSubmit')->name('add.new.bank.submit');
            Route::post('edit/bank/submit', 'ManageSalaryController@editBankSubmit')->name('edit.bank.submit');
            Route::post('add/new/bank/branch/submit', 'ManageSalaryController@addNewBranchSubmit')->name('add.new.branch.submit');
            Route::post('edit/bank/branch/submit', 'ManageSalaryController@editBranchSubmit')->name('edit.branch.submit');
            Route::get('delete/bank/{bank}', 'ManageSalaryController@deleteBank')->name('delete.bank');

            // manage salary

            Route::get('manage/salary/list', 'ManageSalaryController@salaryList')->middleware(['permission:' . Permissions::ADMIN_SALARY_VIEW])->name('manage.salary.list.view');
            Route::get('manage/salary/list/data', 'ManageSalaryController@salaryListData')->middleware(['permission:' . Permissions::ADMIN_SALARY_VIEW])->name('manage.salary.list');
            Route::get('manage/salary/list/query', 'ManageSalaryController@salaryListQuery')->middleware(['permission:' . Permissions::ADMIN_SALARY_VIEW])->name('manage.salary.query');
            Route::get('manage/salary', 'ManageSalaryController@index')->middleware(['permission:' . Permissions::ADMIN_SALARY_VIEW])->name('manage.salary.view');
            Route::get('manage/salary/load-form', 'ManageSalaryController@salaryLoadForm')->middleware(['permission:' . Permissions::ADMIN_SALARY_VIEW])->name('manage.salary.load.form');
            Route::post('manage/salary/create/new', 'ManageSalaryController@createEmployeeSalary')->middleware(['permission:' . Permissions::ADMIN_SALARY_CREATE])->name('manage.salary.employee.create');
            Route::get('manage/salary/update/{id}/{salary_id}', 'ManageSalaryController@updateSalaryForm')->middleware(['permission:' . Permissions::ADMIN_SALARY_EDIT])->name('manage.salary.update.form');
            Route::post('manage/salary/update', 'ManageSalaryController@updateEmployeeSalary')->middleware(['permission:' . Permissions::ADMIN_SALARY_EDIT])->name('manage.salary.update');
            Route::get('manage/salary/increment/{id}/{salary_id}', 'ManageSalaryController@salaryIncrementView')->middleware(['permission:' . Permissions::ADMIN_SALARY_CREATE])->name('manage.salary.increment.view');
            Route::post('manage/salary/increment/submit', 'ManageSalaryController@salaryIncrementSubmit')->middleware(['permission:' . Permissions::ADMIN_SALARY_CREATE])->name('manage.salary.increment.submit');
            Route::get('salary-breakdown', 'ManageSalaryController@getSalaryBreakdown')->middleware(['permission:' . Permissions::ADMIN_SALARY_VIEW])->name('getSalaryBreakdown');
            Route::get('manage/salary/settings', 'ManageSalaryController@salarySettings')->middleware(['permission:' . Permissions::ADMIN_SALARY_VIEW])->name('salarySettings');
            Route::post('manage/salary/settings', 'ManageSalaryController@salarySettingsSubmit')->middleware(['permission:' . Permissions::ADMIN_SALARY_CREATE]);


            Route::get('salary-generate', 'ManageSalaryController@generateSalaryView')->middleware(['permission:' . Permissions::ADMIN_SALARY_VIEW])->name('generate.salary');
            Route::post('salary-regenerate', 'ManageSalaryController@salaryRegenerate')->name('regenerate.salary');
            Route::get('salary-generate/{type}', 'ManageSalaryController@generateSalary')->name('generate.emp.salary');
            Route::get('payslip-view/{id}/{type}', 'ManageSalaryController@paySlipView')->name('paySlip.emp.view');
            Route::get('payslip-download/{id}/{type}', 'ManageSalaryController@downloadPaySlip')->name('paySlip.emp.download');
            Route::get('salary-clearance/{type}', 'ManageSalaryController@clearanceSalary')->name('clearance.emp.salary');
            Route::get('salary-export/{type}', 'ManageSalaryController@exportSalary')->name('export.emp.salary');
            Route::get('salary/history', 'ManageSalaryController@salaryHistory')->middleware(['permission:' . Permissions::ADMIN_SALARY_VIEW])->name('manage.salary.history');
            Route::get('salary/history/individual', 'ManageSalaryController@salaryHistoryIndividual')->name('manage.salary.history.individual');
            Route::get('salary/validation/{type}', 'ManageSalaryController@salaryValidationCheck')->name('salary.validation');
            Route::get('salary/generate', 'ManageSalaryController@generateSalaryConfView')->name('manage.salary.create');
            Route::get('release/previous/hold/{month}/{year}/list', 'ManageSalaryController@releasePreviousHold')->name('salary.release.previous.hold.list');
            Route::get('salary/hold/{id}/release', 'ManageSalaryController@salaryHoldRelease')->name('salary.hold.release');
            Route::put('salary/hold/{id}/release/update', 'ManageSalaryController@salaryHoldReleaseUpdate')->name('salary.hold.release.update');

            // Employee Hour Upload
            Route::get('salary/add-employee-hours', 'ManageSalaryController@addEmployeeHours')->name('add.salary.employee.hours');
            Route::get('salary/employee-hours/{id}/edit', 'ManageSalaryController@editEmployeeHours')->name('edit.salary.employee.hours');
            Route::get('salary/employee-hours', 'ManageSalaryController@employeeHours')->name('manage.salary.employee.hours');
            Route::post('salary/update-employee-hours', 'ManageSalaryController@updateEmployeeHour')->name('update.salary.employee.hours');
            Route::post('salary/employee-hours', 'ManageSalaryController@importEmployeeHourCsv')->name('upload.salary.employee.hours');
            Route::get('salary/upload-employee-hours', 'ManageSalaryController@employeeHoursUploadView')->name('upload.salary.employee.hours.view');
            Route::get('salary/employee-hours/clearance/{startDate}/{endDate}', 'ManageSalaryController@employeeHoursClearanceView')->name('upload.salary.employee.hours.clearance.view');
            Route::post('salary/employee-hours/clearance/update', 'ManageSalaryController@employeeHoursClearanceUpdate')->name('upload.salary.employee.hours.clearance.update');

            // Employee Attendance Upload
            Route::get('salary/add-employee-attendance', 'ManageSalaryController@addEmployeeAttendances')->name('add.salary.employee.attendance');
            Route::post('salary/save-employee-attendance', 'ManageSalaryController@saveEmployeeAttendances')->name('save.salary.employee.attendance');
            Route::get('salary/employee-attendance/{id}/edit', 'ManageSalaryController@editEmployeeAttendance')->name('edit.salary.employee.attendance');
            Route::get('salary/employee-attendance', 'ManageSalaryController@employeeAttendances')->name('manage.salary.employee.attendance');
            Route::get('salary/employee-attendance/{id}/delete', 'ManageSalaryController@employeeAttendances')->name('manage.salary.employee.attendance.delete');
            Route::post('salary/update-employee-attendance', 'ManageSalaryController@updateEmployeeAttendance')->name('manage.update.salary.employee.attendance');
            Route::post('salary/employee-attendance', 'ManageSalaryController@importEmployeeAttendanceCsv')->name('upload.salary.employee.attendance');
            Route::get('salary/upload-employee-attendance', 'ManageSalaryController@employeeAttendanceUploadView')->name('upload.salary.employee.attendance.view');
            Route::get('salary/employee-attendance/clearance/{startDate?}/{endDate?}', 'ManageSalaryController@employeeAttendancesClearanceView')->name('upload.salary.employee.attendance.clearance.view');
            Route::post('salary/employee-attendance/clearance/update', 'ManageSalaryController@employeeAttendanceClearanceUpdate')->name('upload.salary.employee.attendance.clearance.update');

            // employee attendance summary
            Route::get('salary/add-employee-attendance-summary', 'ManageSalaryController@addEmployeeAttendanceSummary')->name('add.salary.employee.attendance-summary');
            Route::get('salary/employee-attendance-summary/{id}/edit', 'ManageSalaryController@editEmployeeAttendanceSummary')->name('edit.salary.employee.attendance-summary');
            Route::get('salary/employee-attendance-summary', 'ManageSalaryController@employeeAttendanceSummary')->name('manage.salary.employee.attendance-summary');
            Route::post('salary/update-employee-attendance-summary', 'ManageSalaryController@updateEmployeeAttendanceSummary')->name('update.salary.employee.attendance-summary');
            Route::post('salary/employee-attendance-summary', 'ManageSalaryController@importEmployeeAttendanceSummaryCsv')->name('upload.salary.employee.attendance-summary');
            Route::get('salary/upload-employee-attendance-summary', 'ManageSalaryController@employeeAttendanceSummaryUploadView')->name('upload.salary.employee.attendance-summary.view');
            Route::get('salary/employee-attendance-summary/clearance/{startDate}/{endDate}', 'ManageSalaryController@employeeAttendanceSummaryClearanceView')->name('upload.salary.employee.attendance-summary.clearance.view');
            Route::post('salary/employee-attendance-summary/clearance/update', 'ManageSalaryController@employeeAttendanceSummaryClearanceUpdate')->name('upload.salary.employee.attendance-summary.clearance.update');


            // payroll reports
            Route::get('report/salary/summary', 'ReportController@summary')->name('manage.salary.summary');
            Route::get('report/salary/status', 'ReportController@salaryStatus')->name('report.payroll.salary.status');
            Route::get('report/process/salary', 'ReportController@processSalaryStatus')->name('report.payroll.process.salary.status');
            Route::get('report/bank/salary', 'ReportController@bankSalaryStatus')->name('report.payroll.bank.salary.status');
            Route::get('report/hold/salary', 'ReportController@holdSalaryStatus')->name('report.payroll.hold.salary.status');
            Route::get('report/cheque/salary', 'ReportController@chequeSalaryStatus')->name('report.payroll.cheque.salary.status');
            Route::get('report/all/salary', 'ReportController@allSalaryStatus')->name('report.payroll.all.salary.status');
            Route::get('report/missing/salary-settings', 'ReportController@missingSalarySettings')->name('report.payroll.all.missing.salary.settings');

        });


        Route::prefix('payroll/process-salary-settings')->namespace('Admin\Payroll')->group(function () {
            //Admin process salary setting
            Route::get('/list', 'ProcessSalarySettingsController@index')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('process.payment.setting.index');
            Route::post('/create', 'ProcessSalarySettingsController@save')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('process.payment.setting.create');
            Route::get('/add', 'ProcessSalarySettingsController@add')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('process.payment.setting.add');
            Route::get('/{id}/edit', 'ProcessSalarySettingsController@edit')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('process.payment.setting.edit');
            Route::put('/{id}/update', 'ProcessSalarySettingsController@update')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('process.payment.setting.update');
            Route::delete('/list/{id}', 'ProcessSalarySettingsController@destroy')->middleware(['permission:' . Permissions::ADMIN_ROLE_DELETE])->name('process.payment.setting.destroy');
        });

        Route::prefix('payroll/provident-fund')->namespace('Admin\Payroll')->group(function () {
            //Admin Provident fund
            Route::get('/history', 'ProvidentFundController@index')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.provident.fund.index');
            Route::get('/{id}/details', 'ProvidentFundController@details')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.provident.fund.details');
            Route::get('/{year}/{month}/downloads', 'ProvidentFundController@downloadTax')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.provident.fund.download');
            Route::get('/pf-upload', 'ProvidentFundController@pfUpload')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.provident.fund.upload');
            Route::post('/store/pf-upload', 'ProvidentFundController@storePfUpload')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.provident.fund.store');
            Route::post('/create', 'ProvidentFundController@store')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.provident.fund.create');
            Route::get('/add', 'ProvidentFundController@add')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.provident.fund.add');
            Route::get('/{id}/edit', 'ProvidentFundController@edit')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.provident.fund.edit');
            Route::put('/{id}/update', 'ProvidentFundController@update')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.provident.fund.update');
            Route::get('/setting', 'ProvidentFundController@setting')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.provident.fund.setting');
            Route::get('/setting', 'ProvidentFundController@setting')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.provident.fund.setting');
            Route::get('/delete', 'ProvidentFundController@setting')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.provident.fund.delete');
            Route::put('/setting/{id}/update', 'ProvidentFundController@settingUpdate')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.provident.fund.setting.update');


            Route::GET('/statement', 'ProvidentFundController@statement')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.provident.fund.statement');
            //Route::GET('/statement/{month}/{year}/generate', 'ProvidentFundController@statementGenerate')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.provident.fund.statement.generate');
            //Route::GET('/statement/{month}/{year}/regenerate', 'ProvidentFundController@statementRegenerate')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.provident.fund.statement.regenerate');
            Route::GET('/statement/{month}/{year}/clearance/view', 'ProvidentFundController@viewClearance')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.provident.fund.statement.view.clearance');
            Route::GET('/statement/{year}/{month}/clearance/generate', 'ProvidentFundController@statementClearance')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.provident.fund.statement.clearance');
            Route::post('/statement/button/enabled/disabled', 'ProvidentFundController@buttonEnabledDisabled')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.provident.fund.statement.button.enabled.disabled');

        });

        Route::prefix('payroll/tax')->namespace('Admin\Payroll')->group(function () {
            //Admin Provident fund
            Route::get('/history', 'TaxController@index')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.tax.index');
            Route::get('/{id}/details', 'TaxController@details')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.tax.fund.details');
            Route::get('/{year}/{month}/downloads', 'TaxController@downloadTax')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.tax.fund.download');
            Route::get('/upload', 'TaxController@taxUpload')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.tax.upload');
            Route::post('/store', 'TaxController@taxStore')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.tax.store');
            Route::post('/create', 'TaxController@store')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.tax.create');
            Route::get('/add', 'TaxController@add')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.tax.add');
            Route::get('/{id}/edit', 'TaxController@edit')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.tax.edit');
            Route::put('/{id}/update', 'TaxController@update')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.tax.update');
            Route::get('/setting', 'TaxController@setting')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.tax.setting');
            Route::get('/setting/add', 'TaxController@settingAdd')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.tax.setting.add');
            Route::post('/setting/save', 'TaxController@settingSave')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.tax.setting.save');
            Route::get('/setting/{id}/edit', 'TaxController@settingEdit')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.tax.setting.edit');
            Route::put('/setting/{id}/update', 'TaxController@settingUpdate')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.tax.setting.update');

            Route::GET('/statement', 'TaxController@statement')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.tax.statement');
            //Route::GET('/statement/generate', 'TaxController@statementGenerate')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.tax.statement.generate');
            //Route::GET('/statement/regenerate', 'TaxController@statementRegenerate')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.tax.statement.regenerate');
            Route::GET('/statement/{month}/{year}/clearance/view', 'TaxController@viewClearance')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.tax.statement.view.clearance');
            Route::GET('/statement/{year}/{month}/clearance/generate', 'TaxController@statementClearance')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.tax.statement.clearance');
            Route::post('/statement/button/enabled/disabled', 'TaxController@buttonEnabledDisabled')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.tax.statement.button.enabled.disabled');
        });


        Route::prefix('payroll/adjustment')->namespace('Admin\Adjustment')->group(function () {
            //Admin Adjustment
            //Route::get('/list', 'AdjustmentController@index')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.adjustment.index');
            Route::get('/list', 'AdjustmentController@index')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.adjustment.index');
            Route::get('/create', 'AdjustmentController@create')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.adjustment.create');
            Route::post('/save', 'AdjustmentController@store')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.adjustment.store');
            Route::get('/{id}/edit', 'AdjustmentController@edit')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.adjustment.edit');
            Route::put('/{id}/update', 'AdjustmentController@update')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.adjustment.update');
            Route::get('/statement', 'AdjustmentController@statement')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.adjustment.statement');
            Route::get('/clearance', 'AdjustmentController@statementClearance')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.adjustment.clearance');

            Route::GET('/statement/{month}/{year}/clearance/view', 'AdjustmentController@viewClearance')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.adjustment.statement.view.clearance');
            Route::GET('/statement/{year}/{month}/clearance/generate', 'AdjustmentController@statementClearance')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.adjustment.statement.clearance');
            Route::post('/statement/button/enabled/disabled', 'AdjustmentController@buttonEnabledDisabled')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.adjustment.statement.button.enabled.disabled');
            Route::get('/{year}/{month}/downloads', 'AdjustmentController@downloadTax')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.adjustment.download');

            // mobile bills
            Route::get('/upload-bills', 'AdjustmentController@uploadBills')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('mobilebill.adjustment.list');
            Route::get('/upload-bills-view', 'AdjustmentController@insertUploadBillsView')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('mobilebill.adjustment.form');
            Route::post('/upload-bills', 'AdjustmentController@insertUploadBills')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('mobilebill.adjustment.insert');
            Route::get('/upload-bill/settings', 'AdjustmentController@uploadBillSettings')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('mobilebill.adjustment.settings');
            Route::post('/upload-bill/settings', 'AdjustmentController@UpdateUploadBillSettings')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('mobilebill.adjustment.settings.save');

            //Adjustment Type
            Route::get('/type/list', 'AdjustmentController@typeIndex')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.adjustment.type.index');
            Route::get('/type/create', 'AdjustmentController@typeCreate')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.adjustment.type.create');
            Route::post('/type/save', 'AdjustmentController@typeStore')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.adjustment.type.store');
            Route::get('/type/{id}/edit', 'AdjustmentController@typeEdit')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.adjustment.type.edit');
            Route::put('/type/{id}/update', 'AdjustmentController@typeUpdate')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.adjustment.type.update');
        });

        Route::prefix('payroll/bonus')->namespace('Admin\Bonus')->group(function () {
            //Admin bonus
            Route::get('/list', 'BonusController@index')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.bonus.index');
            Route::get('/create', 'BonusController@create')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.bonus.create');
            Route::post('/save', 'BonusController@store')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.bonus.store');
            Route::get('/{id}/edit', 'BonusController@edit')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.bonus.edit');
            Route::put('/{id}/update', 'BonusController@update')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.bonus.update');
            Route::get('/history/list', 'BonusController@history')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.bonus.history');
        });

        Route::prefix('payroll/salary/hold')->namespace('Admin\SalaryHold')->group(function () {
            //Admin Salary Hold
            Route::get('/list', 'SalaryHoldController@index')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.salary.hold.index');
            Route::get('/create', 'SalaryHoldController@create')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.salary.hold.create');
            Route::post('/save', 'SalaryHoldController@store')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.salary.hold.store');
            Route::get('/{id}/edit', 'SalaryHoldController@edit')->middleware(['permission:' . Permissions::ADMIN_ROLE_CREATE])->name('payroll.salary.hold.edit');
            Route::put('/{id}/update', 'SalaryHoldController@update')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.salary.hold.update');
            Route::get('/history/list', 'SalaryHoldController@history')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.salary.hold.history');
            Route::get('/statement', 'SalaryHoldController@statement')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.salary.hold.statement');
            Route::get('/{year}/{month}/downloads', 'SalaryHoldController@downloadTax')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('payroll.salary.hold.download');

            Route::GET('/statement/{month}/{year}/clearance/view', 'SalaryHoldController@viewClearance')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.hold.statement.view.clearance');
            Route::GET('/statement/{year}/{month}/clearance/generate', 'SalaryHoldController@statementClearance')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.hold.statement.clearance');
            Route::post('/statement/button/enabled/disabled', 'SalaryHoldController@buttonEnabledDisabled')->middleware(['permission:' . Permissions::ADMIN_ROLE_EDIT])->name('payroll.hold.statement.button.enabled.disabled');
        });

        Route::prefix('employee/closing/setup')->namespace('Admin\Closing')->group(function () {
            //Employee Evaluation Setup
            Route::get('/setting', 'SettingExitInterviewController@index')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.interview');
            Route::get('/setting/create', 'SettingExitInterviewController@create')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.interview.create');
            Route::post('/setting/save', 'SettingExitInterviewController@store')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.interview.store');
            Route::get('/setting/{id}/edit', 'SettingExitInterviewController@edit')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.interview.edit');
            Route::put('/setting/{id}/edit', 'SettingExitInterviewController@update')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.interview.update');
            Route::get('/setting/answer', 'SettingExitInterviewController@answer')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.interview.answer');
            Route::get('/setting/answer/create', 'SettingExitInterviewController@answerCreate')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.interview.answer.create');
            Route::post('/setting/answer/save', 'SettingExitInterviewController@answerStore')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.interview.answer.store');
            Route::get('/setting/answer/{id}/edit', 'SettingExitInterviewController@answerEdit')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.interview.answer.edit');
            Route::put('/setting/answer/{id}/edit', 'SettingExitInterviewController@answerUpdate')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.interview.answer.update');
        });

        Route::prefix('employee/appraisal/setting')->namespace('Admin\Appraisal\Setting')->group(function () {
            //Employee Appraisal Setting
            Route::get('/question', 'AppraisalSettingController@index')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.appraisal.question.setting');
            Route::get('/question/create', 'AppraisalSettingController@create')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.appraisal.question.setting.create');
            Route::post('/question/save', 'AppraisalSettingController@store')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.appraisal.question.setting.store');
            Route::get('/question/{id}/edit', 'AppraisalSettingController@edit')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.appraisal.question.setting.edit');
            Route::put('/question/{id}/edit', 'AppraisalSettingController@update')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.appraisal.question.setting.update');

            Route::get('/answer', 'AppraisalSettingController@answer')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.appraisal.answer.setting');
            Route::get('/answer/create', 'AppraisalSettingController@answerCreate')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.appraisal.answer.setting.create');
            Route::post('/filter/appraisal/question/list', 'AppraisalSettingController@filterAppraisalQuestionList')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('filter.appraisal.question.list');

            Route::post('/answer/save', 'AppraisalSettingController@answerStore')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.appraisal.answer.setting.store');
            Route::get('/answer/{id}/edit', 'AppraisalSettingController@answerEdit')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.appraisal.answer.setting.edit');
            Route::put('/answer/{id}/edit', 'AppraisalSettingController@answerUpdate')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('admin.employee.appraisal.answer.setting.update');
        });


        //Missing Report
        Route::prefix('missing/report/employee')->namespace('Admin\Report')->group(function () {
            Route::get('/hour/csv', 'MissingReportController@employeeHourCsv')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('missing.report.employee.hour.csv');
            Route::get('/attendance/csv', 'MissingReportController@employeeAttendanceCsv')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('missing.report.employee.attendance.csv');
            Route::get('/kpi/csv', 'MissingReportController@employeeKpiCsv')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('missing.report.kpi.csv');
            Route::get('/pf/csv', 'MissingReportController@employeePfCsv')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('missing.report.pf.csv');
            Route::get('/tax/csv', 'MissingReportController@employeeTaxCsv')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('missing.report.tax.csv');
        });

        //Broadcast
        Route::prefix('broadcast')->namespace('Admin\Report')->group(function () {
            Route::get('/settings', 'BroadcastController@broadcastSettings')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('broadcast.setting');
            Route::post('/settings/store', 'BroadcastController@broadcastStore')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('broadcast.setting.store');
            Route::get('/settings/{id}/eidt', 'BroadcastController@broadcastEdit')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('broadcast.setting.edit');
            Route::put('/settings/{id}/update', 'BroadcastController@broadcastUpdate')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('broadcast.setting.update');
            Route::get('/settings/{id}/delete', 'BroadcastController@broadcastDelete')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('broadcast.setting.delete');
            Route::get('/history', 'BroadcastController@broadcastHistory')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('broadcast.history');
        });

        //Upcoming Expired contractual and probation report...
        Route::prefix('expired')->namespace('Admin\Report')->group(function () {
            Route::get('/contractual', 'ExpiredController@expiredContractual')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('expired.contractual');
            Route::get('/probation', 'ExpiredController@expiredProbation')->middleware(['permission:' . Permissions::ADMIN_ROLE_VIEW])->name('expired.probation');
        });


    });
});

// User Routes
Route::group(['middleware' => 'role:User'], function () {

    // impersonate stop
    Route::get('/users/stop', 'Admin\Employee\EmployeeController@stopImpersonate')->middleware(['employment_status_check', 'first_login_change_password', 'impersonate'])->name('stopImpersonate');

    Route::prefix('user')->namespace('User')->middleware(['employment_status_check', 'first_login_change_password', 'impersonate'])->group(function () {

        // switching to admin login
        Route::any('/login/as-admin', 'UserHomeController@loginAsAdmin')->name('user.loginAsAdmin');

        Route::middleware(['user_route_redirect'])->group(function () {
            // dashboard

            Route::get('/test', 'UserHomeController@leaveTest')->name('user.test');

            Route::get('/dashboard', 'UserHomeController@dashboard')->name('user.dashboard');
            Route::post('/checkin', 'UserHomeController@attendanceCheckinOut')->name('user.attendance.checkin.out');
            Route::get('/home', 'UserHomeController@index')->name('user.home');
            Route::post('/propic/upload', 'UserHomeController@propicUpload')->name('user.profilePic.upload');

            Route::get('/home/user-details/', 'UserHomeController@userDetails')->name('user.details');
            Route::get('/home/change-password/', 'UserHomeController@changePasswordView')->name('user.change.password');
            Route::post('/home/change-password/', 'UserHomeController@changePassword');

            // user profile update
            Route::get('/profile/update', 'UserHomeController@updateProfileView')->name('user.update.profile.view');
            Route::post('/profile/update/submit', 'UserHomeController@updateProfileSubmit')->name('user.update.profile.submit');


            Route::prefix('resource')->group(function () {
                Route::get('library', 'UserResourceLibController@library')->name('user.resource.list');
            });

            // roster
            Route::prefix('roster')->group(function () {
                // create roster
                Route::get('/create', 'RosterController@createView')->middleware(['permission:' . Permissions::TEAM_VIEW . '|' . Permissions::TEAM_CREATE])->name('user.roster.create.view');
                Route::post('/create/submit', 'RosterController@createSubmit')->middleware(['permission:' . Permissions::TEAM_VIEW . '|' . Permissions::TEAM_CREATE])->name('user.roster.create.submit');
                // revise roster
                Route::any('/revise', 'RosterController@reviseView')->name('user.roster.revise.view');
                Route::post('/revise/roster/change', 'RosterController@reviseChangeRoster')->middleware(['permission:' . Permissions::TEAM_VIEW . '|' . Permissions::TEAM_CREATE])->name('user.roster.revise.change');
                Route::post('/revise/roster/submit', 'RosterController@reviseSubmitRoster')->middleware(['permission:' . Permissions::TEAM_VIEW . '|' . Permissions::TEAM_CREATE])->name('user.roster.revise.submit');
                // roster review and approve (teamlead end)
                Route::get('/riview/{notificationId?}', 'RosterController@reviewView')->middleware(['permission:' . Permissions::TEAM_VIEW . '|' . Permissions::TEAM_CREATE])->name('user.roster.review.view');
                Route::post('/riview/roster/submit', 'RosterController@reviewSubmitRoster')->middleware(['permission:' . Permissions::TEAM_VIEW . '|' . Permissions::TEAM_CREATE])->name('user.roster.review.submit');
                // Roster Excel File Uploader
                Route::get('/csv/upload', 'CsvUpload\CsvUploadController@index')->middleware(['permission:' . Permissions::USER_ROSTER_VIEW])->name('user.roster.upload');
                Route::post('/csv/save', 'CsvUpload\CsvUploadController@saveRoster')->middleware(['permission:' . Permissions::USER_ROSTER_CREATE])->name('user.roster.save');
            });

            // Team
            Route::prefix('team')->group(function () {
                // team
                Route::get('/', 'UserTeamController@teamListView')->name('user.team.list.view');
                // team members
                Route::get('/{id}/members', 'UserTeamController@teamMemberListView')->name('user.team.member.list.view');
                Route::get('members/{user_id}/add', 'UserTeamController@addTeamMemberByUser')->middleware(['permission:' . Permissions::TEAM_CREATE])->name('user.team.member.create');
                Route::post('members/save', 'UserTeamController@saveTeamMemberByUser')->middleware(['permission:' . Permissions::TEAM_CREATE])->name('user.team.member.save');
                Route::get('members/{employe_id}/{user_id}/remove', 'UserTeamController@removeTeamMemberByUser')->middleware(['permission:' . Permissions::TEAM_DELETE])->name('user.team.member.remove');
                // create team roster
                Route::get('/create/team/{id}/roster', 'UserTeamController@createTeamRosterView')->middleware(['permission:' . Permissions::USER_ROSTER_VIEW . '|' . Permissions::USER_ROSTER_CREATE])->name('user.team.roster.create.view');
                Route::post('/create/team/roster/submit', 'UserTeamController@createTeamRosterSubmit')->middleware(['permission:' . Permissions::USER_ROSTER_CREATE])->name('user.team.roster.create.submit');
            });

            // attendance
            Route::prefix('attandance')->group(function () {
                // ajax attendance modal info
                Route::post('/details', 'AttendanceController@attendanceDetails')->name('user.team.attandance.details');
                Route::post('/roster/details', 'AttendanceController@rosterDetails')->name('user.roster.details');

                // team members attendance
                Route::get('/team', 'AttendanceController@teamAttendance')->middleware(['permission:' . Permissions::TEAM_VIEW])->name('user.team.attandance.view');
                Route::get('/team/submit', 'AttendanceController@teamAttendanceSubmit')->middleware(['permission:' . Permissions::TEAM_VIEW])->name('user.team.attendance.submit');

                // team members live attendance
                Route::get('/team/now-at-office', 'AttendanceController@teamAttendanceNowAtOffice')->name('user.team.attandance.now.at.office.view');
                Route::get('/team/now-at-office/submit', 'AttendanceController@teamAttendanceNowAtOfficeSubmit')->name('user.team.attendance.now.at.office.submit');

                // user attendance
                Route::get('/', 'AttendanceController@userAttendance')->name('user.attendance.view');

                // Attendance Excel File Uploader
                Route::get('/csv/upload', 'CsvUpload\CsvUploadController@attendence')->middleware(['permission:' . Permissions::USER_ATTENDANCE_VIEW])->name('user.attendance.upload');
                Route::post('/csv/save', 'CsvUpload\CsvUploadController@importCsv')->middleware(['permission:' . Permissions::USER_ATTENDANCE_CREATE])->name('user.attendance.save');

                // Attendance Change request & approve
                Route::post('/change/request/', 'AttendanceController@attendanceChangeRequest')->name('user.attendance.change.request');
                Route::get('/change/approval/', 'AttendanceController@attendanceChangeApproval')->middleware(['permission:' . Permissions::TEAM_VIEW])->name('user.attendance.change.approval');
                Route::post('/change/approval/', 'AttendanceController@attendanceChangeApprovalSubmit')->middleware(['permission:' . Permissions::TEAM_VIEW]);

                // Hourly attendance
                Route::get('/hourly-attendance', 'AttendanceController@hourlyAttendance')->name('user.hourly.attendance.view');
            });


            Route::prefix('asset')->group(function () {
                Route::get('/my-assets', 'UserAssetController@myAssets')->name('myAsset.index');
                Route::get('/my-requisitions', 'UserAssetController@myRequisition')->name('asset.my.requisition');
                Route::get('delete/my-requisitions/{id}', 'UserAssetController@deleteMyRequisition')->name('asset.my.requisition.delete');
                Route::post('/requisition/create', 'UserAssetController@requisition_store')->name('asset.requisition.create');
                Route::get('/requisition/add', 'UserAssetController@requisition_add')->name('asset.requisition.add');
                Route::get('/requisition/{id}/edit', 'UserAssetController@requisition_edit')->name('asset.my.requisition.edit');
                Route::get('/requisition/{id}/view', 'UserAssetController@requisition_view')->name('asset.my.requisition.view');
                Route::put('/requisition/{id}/update', 'UserAssetController@requisition_update')->name('asset.my.requisition.update');
            });


            //user even and notice
            Route::prefix('user/notices')->group(function () {
                Route::get('notice/board', 'NoticeEventControllers@noticeBoard')->name('employee.notice.board');
                Route::get('event/calender', 'NoticeEventControllers@eventCalender')->name('employee.event.calender');
                Route::get('{id}/details', 'NoticeEventControllers@showNoticeEventUser')->name('show.notices.event.user');
            });


            //user Resource Library
            Route::prefix('user/resource/lib')->group(function () {
                Route::get('index', 'ResourceLibControllers@library')->name('employee.resource.library');
                Route::get('{id}/view', 'ResourceLibControllers@libraryView')->name('employee.resource.view');
            });


            //user document and letter
            Route::prefix('documents/letter')->group(function () {
                Route::get('request', 'LetterAndDocController@userRequestDocAndLetter')->name('employee.letter.and.documents');
                Route::post('request/get', 'LetterAndDocController@getDocumentSetupTemplate')->name('employee.documents.setup.template');
                Route::post('request/save', 'LetterAndDocController@saveDocAndLetter')->name('employee.letter.and.documents.save');
                Route::get('request/history', 'LetterAndDocController@userRequestHistory')->name('employee.request.history');
                Route::get('history', 'LetterAndDocController@userDocumentHistory')->name('employee.documents.history');
                Route::get('employee/generate/letter-docs/{id}/pdf', 'LetterAndDocController@documentAndLetterWithPdf')->name('employee.letter.and.documents.pdf');
            });


            //user appraisal
            Route::prefix('user/appraisal')->namespace('Appraisal')->group(function () {
                /*evaluation by team lead*/
                Route::get('evaluation/lead/list', 'EvaluationController@index')->name('user.lead.evaluation.list');
                Route::get('evaluation/lead/new/create', 'EvaluationController@create')->name('user.lead.evaluation.create');
                Route::post('evaluation/lead/save', 'EvaluationController@store')->name('user.lead.evaluation.save');
                Route::get('evaluation/lead/{id}/view', 'EvaluationController@show')->name('user.lead.evaluation.view');
                Route::get('evaluation/lead/{id}/edit', 'EvaluationController@edit')->name('user.lead.evaluation.edit');
                Route::put('evaluation/lead/{id}/update', 'EvaluationController@update')->name('user.lead.evaluation.update');


                /*appraisal for team lead*/
                Route::get('appraisal/lead/list', 'EvaluationController@appraisalListByLead')->name('user.lead.appraisal.list');
                Route::get('appraisal/lead/{id}/recommend', 'EvaluationController@appraisalRecommendByLead')->name('user.lead.appraisal.recommend');
                Route::put('appraisal/lead/recommend/{id}/store', 'EvaluationController@appraisalRecommendByLeadStore')->name('user.lead.appraisal.recommend.store');

                /*Hr appraisal approval*/
                Route::get('appraisal/hr/list', 'EvaluationController@appraisalListByHr')->name('user.hr.appraisal.list');
                Route::get('appraisal/hr/{id}/list', 'EvaluationController@appraisalRecommendShowByHr')->name('user.hr.appraisal.recommend');
                Route::put('appraisal/hr/{id}/approved', 'EvaluationController@appraisalApprovedByHr')->name('user.hr.appraisal.approved');

                /*Lead evaluation recommend*/
                Route::get('evaluation/team/{teamId}/evaluation/{evaluationId}/list', 'EvaluationController@indexMember')->name('user.lead.evaluation.member.list');
                //Route::get('evaluation/employee/{employeeId}/evaluation/{evaluationId}/review','EvaluationController@memberEvaluationReview')->name('user.lead.evaluation.review.member');
                Route::get('evaluation/employee/evaluation/{mstId}/review', 'EvaluationController@memberEvaluationReview')->name('user.lead.evaluation.review.member');
                Route::put('evaluation/employee/evaluation/review/{id}/store', 'EvaluationController@storeMemberEvaluationReview')->name('user.lead.evaluation.review.store');

                /*appraisal for user */
                Route::get('appraisal/my/list', 'AppraisalController@indexAppraisal')->name('user.my.appraisal.list');
                Route::get('appraisal/my/new/create', 'AppraisalController@createAppraisal')->name('user.my.appraisal.create');
                Route::post('appraisal/my/save', 'AppraisalController@storeAppraisal')->name('user.my.appraisal.save');
                Route::get('appraisal/my/{id}/view', 'AppraisalController@showAppraisal')->name('user.my.appraisal.view');
                Route::get('appraisal/my/{id}/edit', 'AppraisalController@editAppraisal')->name('user.my.appraisal.edit');
                Route::put('appraisal/my/{id}/update', 'AppraisalController@updateAppraisal')->name('user.my.appraisal.update');

                Route::get('evaluation/my/list', 'AppraisalController@indexEvaluation')->name('user.my.evaluation.list');
                Route::get('evaluation/my/dashboard', 'AppraisalController@myEvaluationDashboard')->name('user.my.evaluation.dashboard');
                Route::get('evaluation/my/new/{id}/create', 'AppraisalController@createMyEvaluation')->name('user.my.evaluation.create');
                Route::post('evaluation/my/{id}/save', 'AppraisalController@storeMyEvaluation')->name('user.my.evaluation.save');
                Route::get('evaluation/my/{id}/evaluation/{evaluationId}/view', 'AppraisalController@showMyEvaluation')->name('user.my.evaluation.view');
                Route::get('evaluation/my/{id}/evaluation/{evaluationId}/accept/{flag}', 'AppraisalController@acceptOrRejectEvaluation')->name('user.my.evaluation.accept.reject');
                Route::get('evaluation/my/{id}/edit', 'AppraisalController@editEvaluation')->name('user.my.evaluation.edit');
                Route::put('evaluation/my/{id}/update', 'AppraisalController@updateEvaluation')->name('user.my.evaluation.update');

                /*Evaluation for team lead*/
                Route::get('evaluation/for/lead/list', 'AppraisalController@leadEvaluationList')->name('evaluation.list.for.lead.by.user');
                Route::get('evaluation/team/lead/new/{id}/create', 'AppraisalController@createLeadEvaluation')->name('user.team.lead.evaluation.create');
                Route::post('evaluation/lead/{id}/save', 'AppraisalController@storeLeadEvaluation')->name('user.lead.evaluation.save');
                Route::get('evaluation/{id}/lead/{evaluationId}/view', 'AppraisalController@showLeadEvaluation')->name('user.lead.evaluation.view');

                Route::get('own/leading/evaluation', 'AppraisalController@ownLeadingEvaluationList')->name('own.leading.evaluation.list');
                Route::get('own/leading/evaluation/dashboard', 'AppraisalController@ownLeadingEvaluationDashboard')->name('own.leading.evaluation.dashboard');
            });


            //user loan
            Route::prefix('loan')->group(function () {
                Route::GET('applications', 'LoanApplicationController@index')->name('loam.application.index');
                Route::GET('applications/create', 'LoanApplicationController@create')->name('loam.application.create');
                Route::GET('applications/loan/emi', 'LoanApplicationController@allEmiHistory')->name('loam.user.emi.history');
                Route::GET('emi/adjustment', 'LoanApplicationController@emiAdjustment')->name('loam.emi.adjustment');
                Route::GET('emi/reduce/application', 'LoanApplicationController@emiReduceApplication')->name('loam.emi.reduce.application');
                Route::POST('emi/reduce/application', 'LoanApplicationController@emiReduceApplicationStore')->name('loam.emi.reduce.application.store');
                Route::POST('applications', 'LoanApplicationController@store')->name('loam.application.store');
                Route::GET('applications/{id}', 'LoanApplicationController@show')->name('loam.application.show');
                Route::GET('applications/{id}/edit', 'LoanApplicationController@edit')->name('loam.application.edit');
                Route::PATCH('applications/{id}', 'LoanApplicationController@update')->name('loam.application.update');
                Route::DELETE('applications/{id}', 'LoanApplicationController@destroy')->name('loam.application.destroy');

                Route::POST('user/loan/term/condition', 'LoanApplicationController@termAndCondition')->name('loan.term.condition');
            });

            Route::prefix('payroll')->group(function () {
                Route::get('payslip-view/{id}/{type}', 'ManageSalaryController@paySlipView')->name('paySlip.employee.view');
                Route::get('payslip-download/{id}/{type}', 'ManageSalaryController@downloadPaySlip')->name('paySlip.employee.download');
                Route::get('salary/history', 'ManageSalaryController@salaryHistory')->name('manage.salary.employee.history');
                Route::get('salary/history/individual', 'ManageSalaryController@salaryHistoryIndividual')->name('manage.salary.employee.history.individual');

                Route::get('salary/add-employee-hours', 'ManageSalaryController@addEmployeeHours')->name('employee.add.salary.employee.hours');
                Route::get('salary/employee-hours/{id}/edit', 'ManageSalaryController@editEmployeeHours')->name('employee.edit.salary.employee.hours');
                Route::get('salary/employee-hours', 'ManageSalaryController@employeeHours')->name('employee.manage.salary.employee.hours');
                Route::post('salary/update-employee-hours', 'ManageSalaryController@updateEmployeeHour')->name('employee.update.salary.employee.hours');
                Route::post('salary/employee-hours', 'ManageSalaryController@importEmployeeHourCsv')->name('employee.upload.salary.employee.hours');
                Route::get('salary/upload-employee-hours', 'ManageSalaryController@employeeHoursUploadView')->name('employee.upload.salary.employee.hours.view');
                Route::get('salary/employee-hours/clearance/{startDate}/{endDate}', 'ManageSalaryController@employeeHoursClearanceView')->name('employee.upload.salary.employee.hours.clearance.view');
                Route::post('salary/employee-hours/clearance/update', 'ManageSalaryController@employeeHoursClearanceUpdate')->name('employee.upload.salary.employee.hours.clearance.update');

                // Route::get('employee-hour-export', 'ManageSalaryController@exportSalary')->name('export.emp.salary');

                // Employee Attendance Upload
                Route::get('salary/add-employee-attendance', 'ManageSalaryController@addEmployeeAttendance')->name('employee.add.salary.employee.attendance');
                Route::get('salary/employee-attendance/{id}/edit', 'ManageSalaryController@editEmployeeAttendance')->name('employee.edit.salary.employee.attendance');
                Route::get('salary/employee-attendance', 'ManageSalaryController@employeeAttendance')->name('employee.manage.salary.employee.attendance');
                Route::post('salary/update-employee-attendance', 'ManageSalaryController@updateEmployeeAttendance')->name('employee.update.salary.employee.attendance');
                Route::get('salary/{id}/delete-employee-attendance', 'ManageSalaryController@deleteEmployeeAttendance')->name('employee.delete.salary.employee.attendance');
                Route::post('salary/employee-attendance', 'ManageSalaryController@importEmployeeAttendanceCsv')->name('employee.upload.salary.employee.attendance');
                Route::get('salary/upload-employee-attendance', 'ManageSalaryController@employeeAttendanceUploadView')->name('employee.upload.salary.employee.attendance.view');
                Route::get('salary/employee-attendance/clearance/{startDate}/{endDate}', 'ManageSalaryController@employeeAttendanceClearanceView')->name('employee.upload.salary.employee.attendance.clearance.view');
                Route::post('salary/employee-attendance/clearance/update', 'ManageSalaryController@employeeAttendanceClearanceUpdate')->name('employee.upload.salary.employee.attendance.clearance.update');
            });


            // Leave
            Route::prefix('leave/documents')->group(function () {
                // Apply leave from employee end.
                Route::get('/application/create', 'LeavesController@leaveApplication')->name('user.leave'); // employee leave apply form
                Route::post('/application/apply', 'LeavesController@leaveApply')->name('user.leave.apply'); // Apply leave
                Route::post('/application/apply/file/upload', 'LeavesController@documentUpload')->name('user.leave.document.upload'); // document upload for leave
                Route::get('/leave/view/{id}/{approval_type?}/{approval_id?}', 'LeavesController@leaveView')->name('leave.view'); // leave modal details view ajax

                Route::post('/checkBridge', 'LeavesController@checkBridge')->name('leave.bridgeCheck'); // check bridge

                // leave requests for Team leader and supervisor
                Route::get('/requests', 'LeavesController@requestedApplicationList')->middleware(['permission:' . Permissions::TEAM_VIEW . '|' . Permissions::SUPERVISOR_VIEW])->name('leave.request'); // leave request for team leader and supervisor end
                Route::post('/approval', 'LeavesController@leaveApproval')->name('leave.approval'); // approve leave request

                // employee leave details/balance history
                Route::get('/dashboard/{id?}', 'LeavesController@leaveDashboard')->name('leave.dashboard'); // employee leave details/balance history
                Route::get('/details/{id?}', 'LeavesController@leaveDetails')->name('leave.list'); // employee leave details/balance history
                Route::get('/view/{id?}', 'LeavesController@leaveView')->name('user.leave.view'); // employee leave view/balance history
                Route::get('/download/{id}', 'LeavesController@leaveDownload')->name('user.leave.download'); // employee leave download/balance history

                // leave cancellation
                Route::get('/cancel-request/{id}', 'LeavesController@cancelLeave')->name('cancel.leave'); // cancel approved leave


                // don't know what is this about done by khayrul start.
                Route::get('/team/history', 'LeavesController@teamLeaveHistory')->name('team.leave.history');
                Route::get('/team/status', 'LeavesController@teamLeaveStatus')->middleware(['permission:' . Permissions::TEAM_VIEW . '|' . Permissions::SUPERVISOR_VIEW])->name('team.leave.status');
                Route::get('/application/requested/data', 'LeavesController@requestedLeaveData')->middleware(['permission:' . Permissions::TEAM_VIEW . '|' . Permissions::SUPERVISOR_VIEW])->name('leave.request.data');
                Route::post('/leave/validation/rules', 'LeavesController@leaveValidationRules')->name('get.leave.validation.rules');
                Route::post('/leave/approval', 'LeavesController@leaveApproval')->name('leave.approval');
                Route::post('/employee/list', 'LeavesController@getEmployeeListByTeamLeadOrSuperVisor')->name('leave.employee.list');
                // don't know what is this about done by khayrul end

                Route::get('/application/requested/data', 'LeavesController@requestedLeaveData')->name('leave.request.data');
                Route::get('/view/{id}/{approval_type?}/{approval_id?}', 'LeavesController@leaveView')->name('leave.view');
                Route::post('/validation/rules', 'LeavesController@leaveValidationRules')->name('get.leave.validation.rules');
                Route::post('/approval', 'LeavesController@leaveApproval')->name('leave.approval');
                Route::post('/employee/list', 'LeavesController@getEmployeeListByTeamLeadOrSuperVisor')->name('leave.employee.list');
            });


            // user Clearance
            Route::prefix('closing')->group(function () {

                // Apply for clearance from employee end.
                Route::get('/application/list', 'ClosingController@index')->name('user.closing.list'); // employee closing apply form
                Route::get('/application/create', 'ClosingController@create')->name('user.closing.create'); // Apply closing
                Route::post('/application/save', 'ClosingController@store')->name('user.closing.store'); // save closing application

                /*Team lead or supervisor closing request*/
                Route::get('/request/closing/list', 'ClosingController@closingRequestList')->name('user.closing.request'); // show closing request show
                Route::get('/closing/{id}/{flag}/approval', 'ClosingController@closingRequestApproval')->name('user.closing.approval.lead.or.supervisor'); // show closing request show
                Route::put('/closing/{id}/{flag}/approval/status/change', 'ClosingController@closingRequestApprovalStatusChange')->name('user.closing.approval.status.change'); // show closing request show

                /*FNF Report*/
                Route::get('/fnf/report', 'ClosingController@fnfReport')->name('fnf.report');
                Route::get('/fnf/report/export', 'ClosingController@fnfExport')->name('fnf.report.export');

                /*Clearance Approval*/
                Route::get('/request/clearance', 'ClosingController@clearance')->name('request.clearance.clearance');
                Route::get('/clearance/approval/{id}/{appId}/show', 'ClosingController@clearanceShow')->name('request.clearance.clearance.show');
                Route::put('/clearance/approval/{id}/approved', 'ClosingController@clearanceApproved')->name('request.clearance.clearance.approved');

                /*HR closing request*/
                Route::get('/user/request/hr', 'ClosingController@userRequestToHr')->name('user.request.clearance.hr');
                Route::get('/user/request/final/closing/hr', 'ClosingController@userRequestFinalClosingToHr')->name('user.final.closing.request.clearance.hr');
                Route::get('/user/request/hr/{id}/show', 'ClosingController@userRequestToHrShow')->name('user.request.clearance.hr.show');
                Route::get('/user/request/hr/{id}/final/approval/show', 'ClosingController@userRequestToHrFinalApprovalShow')->name('user.request.clearance.hr.final.approval.show');
                Route::put('/user/request/hr/{id}/change', 'ClosingController@userRequestToHrChangeStatus')->name('user.request.clearance.hr.change.status');
                Route::put('/user/request/hr/{id}/final/approval/change', 'ClosingController@userRequestToHrFinalApprovalChangeStatus')->name('user.request.clearance.hr.final.approval.change.status');

                /*Own Department HOD or In-Charge*/
                Route::get('own/department/to/clearance', 'ClosingController@ownDepartmentToClearance')->name('own.department.to.clearance');
                Route::get('own/department/to/clearance/{id}/{appId}/{flag}/show', 'ClosingController@ownDepartmentToClearanceShow')->name('own.department.to.clearance.show');
                Route::put('own/department/to/clearance/{id}/{flag}/approved', 'ClosingController@ownDepartmentToClearanceApproved')->name('own.department.to.clearance.approved');

                /*Employee Evaluation exit interview*/
                Route::get('employee/evaluation/{id}/create', 'ExitInterviewController@create')->name('employee.exit.interview.create');
                Route::put('employee/evaluation/{id}/save', 'ExitInterviewController@store')->name('employee.evaluation.save');
            });


            Route::prefix('upcomming')->group(function () {
                Route::get('show', 'UpcommingEventController@index')->name('upcomming.index');
            });
        });
    });
});

Route::GET('/api/departments', 'ApiController@departments')->name('api.departments');
Route::GET('/api/employees', 'ApiController@employees')->name('api.employees');
Route::GET('/api/hiring/request', 'ApiController@hiringRequisition')->name('api.hiring');
Route::GET('/api/hiring/request/views/{id}', 'ApiController@hiringRequestViews')->name('api.hiring.view');


// Check nda
Route::GET('/check/nda', 'Back-HomeController@checkoutNda')->name('check.nda');
Route::POST('/info/update/nda', 'Back-HomeController@ndaUpdate')->name('update.info.nda');
Route::GET('/info/show/doc/nda', 'Back-HomeController@showDocNda')->name('show.info.doc.nda');
Route::POST('/store/doc/nda', 'Back-HomeController@storeDocNda')->name('store.info.doc.nda');
