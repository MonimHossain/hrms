<?php

Route::group([

    'prefix' => 'public'

], function () {
    Route::get('directory/{keys}', 'AuthController@directory');
    Route::get('directory/employee/{id}', 'AuthController@employeeInfo');
});

Route::post('auth/login', 'AuthController@login');
Route::post('auth/adminlogin', 'AuthController@adminLogin');

Route::group([

     'middleware' => 'auth:api',
    // 'middleware' => 'cors',
    'prefix' => 'auth'

], function () {

    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('holidays', 'AuthController@holidays');
    Route::post('birthdays', 'AuthController@birthdays');
    Route::post('nearMe', 'AuthController@nearMe');
    Route::post('notice', 'AuthController@noticeBoard');
    Route::post('pinned-notice', 'AuthController@pinnedNoticeBoard');
    Route::post('noticeDetails/{id}', 'AuthController@showNoticeEventUser');
    Route::post('event', 'AuthController@eventCalender');
    Route::post('blood-groups', 'AuthController@bloodGroups');
    Route::post('blood-group/{id}', 'AuthController@bloodGroup');
    Route::post('directory/{keys}', 'AuthController@directory');
    Route::post('directory/employee/{id}', 'AuthController@employeeInfo');



});
Route::middleware('auth:api')->namespace('ApiControllers')->prefix('leave')->group(function () {

    Route::get('/leave-types', 'LeaveApiController@leaveTypes'); // get all leave types
    Route::get('/leave-reasons', 'LeaveApiController@leaveReasons'); // get all leave reasons
    Route::get('/balance/{id}/{year?}', 'LeaveApiController@leaveBalances'); // get leave balances
    Route::get('/list/{id}', 'LeaveApiController@leaveLists'); // get individual leave lists

    Route::post('/apply', 'LeaveApiController@leaveApply'); // Leave Apply

    Route::get('/request/{empId}', 'LeaveApiController@leaveRequestLists'); // get leave request lists
    Route::post('/request/approved', 'LeaveApiController@leaveApproval'); // Leave Apply

});
// Route::middleware('auth:api')->get('user', 'UserHomeController@AuthRouteAPI');

