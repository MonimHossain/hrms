<!-- begin:: Aside -->
<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

    <!-- begin:: Aside -->
    <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
        <div class="kt-aside__brand-logo">
            @if(request()->session()->get('validateRole') == 'Admin')
                <a href="{{ route('dashboard') }}">
                    <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2.png') }}"/>
                </a>
            @endif
            @if(request()->session()->get('validateRole') == 'User')
                <a href="{{ route('user.dashboard') }}">
                    <img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2.png') }}"/>
                </a>
            @endif
        </div>
        <div class="kt-aside__brand-tools">
            <button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler">
                <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                           class="kt-svg-icon">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
                            <path
                                d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                                id="Path-94" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) "/>
                            <path
                                d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                                id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3"
                                transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) "/>
                        </g>
                    </svg></span>
                <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                           class="kt-svg-icon">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
                            <path
                                d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                id="Path-94" fill="#000000" fill-rule="nonzero"/>
                            <path
                                d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3"
                                transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
                        </g>
                    </svg></span>
            </button>
            <!--
            <button class="kt-aside__brand-aside-toggler kt-aside__brand-aside-toggler--left" id="kt_aside_toggler"><span></span></button>
            -->
        </div>
    </div>

    <!-- end:: Aside -->

    <!-- begin:: Aside Menu -->
    <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper"
         style="background-image: url({{ asset('assets/media/bg/sidebar.jpg') }}); background-position: center top; background-size: 100%;">
        <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
            <ul class="kt-menu__nav ">

                {{-- menus for Admin roles --}}
                {{-- @hasrole('Super Admin|Admin') --}}
                @if(auth()->user()->hasAnyRole('Super Admin|Admin') && request()->session()->get('validateRole') == 'Admin')


                    {{-- dashboard --}}
                    <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('dashboard') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-home"></i><span
                                class="kt-menu__link-text">Dashboard</span></a></li>
                    {{-- employee --}}
                    @canany([ _permission(\App\Utils\Permissions::EMPLOYEE_LIST_VIEW), _permission(\App\Utils\Permissions::EMPLOYEE_PROFILE_VIEW), _permission(\App\Utils\Permissions::EMPLOYEE_CREATE), _permission(\App\Utils\Permissions::EMPLOYEE_EDIT), _permission(\App\Utils\Permissions::EMPLOYEE_DELETE)])
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here
                                {{ ($active == 'employee') ? 'kt-menu__item--open' :
                                    (($active == 'employee-inactive')? 'kt-menu__item--open' :
                                    (($active == 'addNewEmp')? 'kt-menu__item--open' :
                                    (($active == 'employeeall')? 'kt-menu__item--open' :
                                    (($active == 'add_new')? 'kt-menu__item--open' :
                                    (($active == 'employeeHirerchy')? 'kt-menu__item--open' :
                                    (($active == 'designationHirerchy')? 'kt-menu__item--open' :
                                    (($active == 'uploadEmployee')? 'kt-menu__item--open' :
                                    (($active == 'unTrackedEmployee')? 'kt-menu__item--open' :
                                    (($active == 'export-data')? 'kt-menu__item--open' :
                                    ''
                                    )))))))))
                                }}"
                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                            <a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">

                        <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                        </span><span class="kt-menu__link-text">Employee</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @can(_permission(\App\Utils\Permissions::EMPLOYEE_LIST_VIEW))
                                        <li class="kt-menu__item {{ ($active == 'employee') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('employee.list.view') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text">Employee List</span></a></li>@endcan
                                    @can(_permission(\App\Utils\Permissions::EMPLOYEE_LIST_VIEW))
                                        <li class="kt-menu__item {{ ($active == 'employee-inactive') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('employee.inactive.list.view') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text">Inactive/Suspended</span></a></li>@endcan
                                    @can(_permission(\App\Utils\Permissions::EMPLOYEE_LIST_VIEW))
                                        <li class="kt-menu__item {{ ($active == 'unTrackedEmployee') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('untracked.employee.list.view') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text">Untracked Employee</span></a></li>@endcan
                                    @can(_permission(\App\Utils\Permissions::EMPLOYEE_CREATE))
                                        <li class="kt-menu__item {{ ($active == 'addNewEmp') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('employee.new.add.view') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Add New</span></a>
                                        </li>@endcan
                                    @can(_permission(\App\Utils\Permissions::EMPLOYEE_CREATE))
                                        <li class="kt-menu__item {{ ($active == 'uploadEmployee') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('employee.bulk.upload.view') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Upload Employee</span></a>
                                        </li>@endcan
                                        <li class="kt-menu__item {{ ($active == 'export-data') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a
                                                href="{{ route('employee.export') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Export Data</span></a>
                                        </li>
                                    {{--                            @can('Employee List View')<li class="kt-menu__item {{ ($active == 'employeeall') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('employee.all.list.view') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Employee Report</span></a></li>@endcan--}}
                                    {{--                            <li class="kt-menu__item {{ ($active == 'employeeHirerchy') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('employee.hierarchy') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Employee Wise Hierarchy</span></a></li>--}}
                                    {{--                            <li class="kt-menu__item {{ ($active == 'designationHirerchy') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('designation.hierarchy') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Designation Wise Hierarchy</span></a></li>--}}

                                </ul>
                            </div>
                        </li>
                    @endcanany

                    {{-- team --}}
                    @canany([ _permission(\App\Utils\Permissions::ADMIN_TEAM_VIEW), _permission(\App\Utils\Permissions::ADMIN_TEAM_CREATE), _permission(\App\Utils\Permissions::ADMIN_TEAM_EDIT), _permission(\App\Utils\Permissions::ADMIN_TEAM_DELETE)])
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ ($active == 'employee-team' || $active == 'employee-team-list') ? 'kt-menu__item--open' : '' }}"
                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">

                    <i class="kt-menu__link-icon flaticon-users"></i>
                    </span><span class="kt-menu__link-text">Team</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @can(_permission(\App\Utils\Permissions::ADMIN_TEAM_VIEW))
                                        <li class="kt-menu__item {{ ($active == 'employee-team-list') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('employee.team.lists') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text">Employee teams</span></a></li>@endcan
                                    @can(_permission(\App\Utils\Permissions::ADMIN_TEAM_VIEW))
                                        <li class="kt-menu__item {{ ($active == 'employee-team') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('employee.team') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Team List</span></a>
                                        </li>@endcan
                                </ul>
                            </div>
                        </li>
                    @endcanany

                    {{-- roster & attendance --}}
                    @canany([ _permission(\App\Utils\Permissions::ADMIN_ROSTER_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROSTER_CREATE), _permission(\App\Utils\Permissions::ADMIN_ATTENDANCE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ATTENDANCE_CREATE)])
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['now-at-office','attendance-dashboard', 'attendance-change-request', 'exec-roster-upload', 'exec-attendance-upload', 'previous-attendance-correction']) ? 'kt-menu__item--open' : '' }}"
                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">

                        <i class="kt-menu__link-icon flaticon-calendar-3"></i>
                    </span><span class="kt-menu__link-text">Roster & Attendanc dasdsade</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">

                                    @can(_permission(\App\Utils\Permissions::ADMIN_ATTENDANCE_VIEW))
                                        <li class="kt-menu__item {{ ($active == 'attendance-dashboard') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('attendance.dashboard') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                class="kt-menu__link-text">Attendance Dashboard</span></a></li>
                                        <li class="kt-menu__item {{ ($active == 'now-at-office')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('Admin.Report.now-at-office') }}" class="kt-menu__link "><i
                                                        class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Now at office</span></a>
                                            </li>
                                    @endcan

                                    @can(_permission(\App\Utils\Permissions::ADMIN_ATTENDANCE_CREATE))
                                    <li class="kt-menu__item {{ ($active == 'attendance-change-request') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('employee.attendance.change.approval') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                class="kt-menu__link-text">Att. Change Requests</span></a></li>@endcan

                                    @can(_permission(\App\Utils\Permissions::ADMIN_ROSTER_CREATE))
                                        <li class="kt-menu__item {{ ($active == 'exec-roster-upload') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('roster.upload') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text">CSV Roster Upload</span></a></li>@endcan
                                    @can(_permission(\App\Utils\Permissions::ADMIN_ATTENDANCE_CREATE))
                                        <li class="kt-menu__item {{ ($active == 'exec-attendance-upload') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('employee.dept.attendance.update.view') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text">Update Attendace Status</span></a></li>
                                        <li class="kt-menu__item {{ ($active == 'exec-attendance-upload') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('attendence.upload') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text">CSV Attendance Upload</span></a></li>

                                        <li class="kt-menu__item {{ ($active == 'previous-attendance-correction') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('previous.attendance.correction.list') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text">Previous Attendance Correction</span></a></li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcanany


                    {{-- Leave --}}
                    @canany([_permission(\app\Utils\Permissions::ADMIN_LEAVE_VIEW)])
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['leave-dashboard', 'leave-application-create', 'leave-details', 'leave-balance-update', 'lwp-approvals', 'leave-yearly-generate']) ? 'kt-menu__item--open' : '' }}"
                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">

                <i class="kt-menu__link-icon flaticon-logout"></i>
                </span><span class="kt-menu__link-text">Leave</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @can(_permission(\App\Utils\Permissions::ADMIN_LEAVE_VIEW))
                                    <li class="kt-menu__item {{ ($active == 'leave-dashboard') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('admin.leave.dashboard') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                class="kt-menu__link-text">Leave Dashboard</span></a></li>@endcan
                                    @can(_permission(\app\Utils\Permissions::ADMIN_LEAVE_CREATE))
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['leave-application-create', 'leave-balance-update', 'leave-yearly-generate']) ? 'kt-menu__item--open' : '' }}"
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript: void(0);" class="kt-menu__link kt-menu__toggle">
                                                <span class="kt-menu__link-icon"><i class="kt-menu__link-icon far fa-dot-circle"></i></span>
                                                <span class="kt-menu__link-text">Leave Balance</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    <li class="kt-menu__item {{ ($active == 'leave-application-create')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                            href="{{ route('admin.leave.application') }}" class="kt-menu__link "><i
                                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Generate Balance & Apply</span></a>
                                                    </li>

                                                    <li class="kt-menu__item {{ ($active == 'leave-balance-update')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                            href="{{ route('admin.leave.balance.update') }}" class="kt-menu__link "><i
                                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Leave Balance Update</span></a>
                                                    </li>
                                                    <li class="kt-menu__item {{ ($active == 'leave-yearly-generate')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                            href="{{ route('admin.leave.balance.generate.yearly') }}" class="kt-menu__link "><i
                                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Yearly Balance Generate</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>



                                        <li class="kt-menu__item {{ ($active == 'leave-details')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('admin.leave.application.details') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Leave Details</span></a>
                                        </li>
                                    @endcan
                                    @can(_permission(\app\Utils\Permissions::ADMIN_LEAVE_APPROVAL_VIEW))
                                        <li class="kt-menu__item {{ ($active == 'lwp-approvals')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('admin.leave.lwp.approvals') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">LWP approvals</span></a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcanany

                    {{-- Start Letter And Document --}}
                    @canany([_permission(\app\Utils\Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW), _permission(\App\Utils\Permissions::ADMIN_LETTER_AND_DOCUMENTS_EDIT), _permission(\App\Utils\Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE), _permission(\App\Utils\Permissions::ADMIN_LETTER_AND_DOCUMENTS_DELETE)])
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['document-create', 'document-history', 'document-template', 'document-request-history', 'document-req-setup-template', 'document-header-template', 'letter-document-report']) ? 'kt-menu__item--open' : '' }}"
                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                <i class="fas fa-hdd"></i>
                </span><span class="kt-menu__link-text">Letter and Documents</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            @can(_permission(\app\Utils\Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW))<li class="kt-menu__item {{ ($active == 'document-request-history')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.document.request.history') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Request History</span></a></li>@endcan
                            @can(_permission(\app\Utils\Permissions::ADMIN_LETTER_AND_DOCUMENTS_CREATE))<li class="kt-menu__item {{ ($active == 'document-create')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.document.create') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Create Document</span></a></li>@endcan
                            @can(_permission(\app\Utils\Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW))<li class="kt-menu__item {{ ($active == 'document-history')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.document.history') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Document History</span></a></li>@endcan

                            {{--setting doc and letter--}}
                            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['letter-document-report']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                            <i class="fas flaticon-settings"></i>
                            </span><span class="kt-menu__link-text">Report</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                    @can(_permission(\app\Utils\Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW))<li class="kt-menu__item {{ ($active == 'letter-document-report')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.letter.document.report') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Reports</span></a></li>@endcan
                                    </ul>
                                </div>
                            </li>

                            <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['document-template', 'document-req-setup-template', 'document-header-template']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                            <i class="fas flaticon-settings"></i>
                            </span><span class="kt-menu__link-text">Settings</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        @can(_permission(\app\Utils\Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW))<li class="kt-menu__item {{ ($active == 'document-template')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.document.template') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Document Template</span></a></li>@endcan
                                        @can(_permission(\app\Utils\Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW))<li class="kt-menu__item {{ ($active == 'document-req-setup-template')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.request.doc.setup') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Request Doc Template</span></a></li>@endcan
                                        @can(_permission(\app\Utils\Permissions::ADMIN_LETTER_AND_DOCUMENTS_VIEW))<li class="kt-menu__item {{ ($active == 'document-header-template')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.doc.header.template') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Doc Header Template</span></a></li>@endcan
                                    </ul>
                                </div>
                            </li>

                        </ul>
                    </div>
                </li>
                @endcanany
                {{--End Letter And Document--}}


                {{-- Start Event and Notice--}}
                @canany([_permission(\app\Utils\Permissions::ADMIN_NOTICE_AND_EVENT_VIEW)])
                <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['new-event-notice', 'notice-board', 'event-calender']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                <i class="fas fa-calendar-day"></i>
                </span><span class="kt-menu__link-text">Notice and Event</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @can(_permission(\app\Utils\Permissions::ADMIN_NOTICE_AND_EVENT_CREATE))
                                        <li class="kt-menu__item {{ ($active == 'new-event-notice')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('admin.new.notice.event') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text">New Notice / Event</span></a></li>@endcan
                                    @can(_permission(\app\Utils\Permissions::ADMIN_NOTICE_AND_EVENT_VIEW))
                                        <li class="kt-menu__item {{ ($active == 'notice-board')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('admin.notice.board') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Notice Board</span></a>
                                        </li>@endcan
                                    @can(_permission(\app\Utils\Permissions::ADMIN_NOTICE_AND_EVENT_VIEW))
                                        <li class="kt-menu__item {{ ($active == 'event-calender')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                href="{{ route('admin.event.calender') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text">Event Calender</span></a></li>@endcan
                                </ul>
                            </div>
                        </li>
                    @endcanany
                    {{-- End Event and Notice--}}


                {{-- Start appraisal--}}
                @canany([
                _permission(\app\Utils\Permissions::APPRAISAL_SETTING_VIEW),
                _permission(\app\Utils\Permissions::APPRAISAL_APPRAISAL_VIEW),
                _permission(\app\Utils\Permissions::APPRAISAL_EVALUATION_VIEW),
                _permission(\app\Utils\Permissions::APPRAISAL_REPORT_VIEW)
                ])
                <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['admin-lead-evaluation-status','appraisal-question-setup-new', 'kpi-percentage-list', 'appraisal-question-setup-list', 'appraisal-history-list', 'appraisal-log-list', 'appraisal-log-new', 'evaluation-history-list', 'evaluation-log-list', 'evaluation-log-new', 'admin-employee-appraisal-question-setting', 'admin-employee-appraisal-answer-setting', 'user-evaluation-analytical-report', 'user-evaluation-analytical-report-team', 'user-evaluation-analytical-report-employee']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                <i class="fas fa-chart-pie"></i>
                </span><span class="kt-menu__link-text">Performance Review</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <ul class="kt-menu__subnav">
                                    @canany([_permission(\App\Utils\Permissions::APPRAISAL_SETTING_VIEW)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['appraisal-question-setup-new', 'appraisal-question-setup-list', 'kpi-percentage-list', 'admin-employee-appraisal-question-setting', 'admin-employee-appraisal-answer-setting']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                    <i class="fas fa-tools"></i>
                                    </span><span class="kt-menu__link-text">Settings</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    <li class="kt-menu__item {{ in_array($active, ['kpi-percentage-list']) ? 'kt-menu__item--open' : '' }} " aria-haspopup="true">
                                                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                                        <span class="kt-menu__link-icon">
                                                        <i class="kt-menu__link-icon flaticon2-settings"></i>
                                                        </span><span class="kt-menu__link-text">General Settings</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                            <ul class="kt-menu__subnav">
                                                                <li class="kt-menu__item {{ ($active == 'kpi-percentage-list')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('kpi.percentage.list') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">KPI Percentage</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li class="kt-menu__item {{ in_array($active, ['appraisal-question-setup-new', 'appraisal-question-setup-list']) ? 'kt-menu__item--open' : '' }}  " aria-haspopup="true">
                                                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                                        <span class="kt-menu__link-icon">
                                                        <i class="fas fa-question"></i>
                                                        </span><span class="kt-menu__link-text">Question Sets</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                            <ul class="kt-menu__subnav">
                                                                <li class="kt-menu__item {{ ($active == 'appraisal-question-setup-new')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('appraisal.question.setup.new') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Add New</span></a></li>
                                                                <li class="kt-menu__item {{ ($active == 'appraisal-question-setup-list')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('appraisal.question.setup.list') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Question Set List</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </li>

                                                    {{--Start employee appraisal setup--}}
                                                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['admin-employee-appraisal-question-setting', 'admin-employee-appraisal-answer-setting']) ? 'kt-menu__item--open' : ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                                    <i class="kt-menu__link-icon flaticon-cogwheel-2"></i>
                                                    </span><span class="kt-menu__link-text">Question Make</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                            <ul class="kt-menu__subnav">
                                                                <li class="kt-menu__item {{ ($active == 'admin-employee-appraisal-question-setting') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{ route('admin.employee.appraisal.question.setting') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Questions</span></a></li>
                                                                <li class="kt-menu__item {{ ($active == 'admin-employee-appraisal-answer-setting') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{ route('admin.employee.appraisal.answer.setting') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Answer</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </li>

                                                    {{--End employee appraisal setup--}}

                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany
                                </ul>
                                <ul class="kt-menu__subnav">
                                    @canany([_permission(\App\Utils\Permissions::APPRAISAL_APPRAISAL_VIEW)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['appraisal-log-new', 'appraisal-log-list', 'appraisal-history-list']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                    <i class="fab fa-steam"></i>
                                    </span><span class="kt-menu__link-text">Appraisals</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    <li class="kt-menu__item {{ ($active == 'appraisal-history-list')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('appraisal.history.list') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Appraisal History</span></a></li>
                                                    <li class="kt-menu__item {{ ($active == 'appraisal-log-list')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('appraisal.log.list') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Appraisal Log</span></a></li>
                                                    <li class="kt-menu__item {{ ($active == 'appraisal-log-new')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('appraisal.log.new') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Add New</span></a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany
                                </ul>
                                <ul class="kt-menu__subnav">
                                    @canany([_permission(\App\Utils\Permissions::APPRAISAL_EVALUATION_VIEW)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['evaluation-history-list', 'evaluation-log-list', 'evaluation-log-new', 'admin-lead-evaluation-status']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                    <i class="fas fa-balance-scale"></i>
                                    </span><span class="kt-menu__link-text">Evaluations</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    <li class="kt-menu__item {{ ($active == 'evaluation-log-new')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('evaluation.log.new') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Create</span></a></li>
                                                    <li class="kt-menu__item {{ ($active == 'evaluation-log-list')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('evaluation.log.list') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Evaluation Log</span></a></li>
                                                    <li class="kt-menu__item {{ ($active == 'evaluation-history-list')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('evaluation.history.list') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Employee Evaluation</span></a></li>
                                                    <li class="kt-menu__item {{ ($active == 'admin-lead-evaluation-status')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.lead.evaluation.status') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Lead Evaluation</span></a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany
                                </ul>

                                <ul class="kt-menu__subnav">
                                    @canany([_permission(\App\Utils\Permissions::APPRAISAL_REPORT_VIEW)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['user-evaluation-analytical-report', 'user-evaluation-analytical-report-team', 'user-evaluation-analytical-report-employee']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                    <i class="fas fa-balance-scale"></i>
                                    </span><span class="kt-menu__link-text">Analytics Report</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    {{--Evaluation Analytical Report--}}
                                                    <li class="kt-menu__item {{ ($active == 'user-evaluation-analytical-report') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{ route('user.evaluation.analytical.report', ['year'=> \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('Y')]) }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Department wise Report</span></a></li>
                                                    <li class="kt-menu__item {{ ($active == 'user-evaluation-analytical-report-team') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{ route('user.evaluation.analytical.report.team') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Team wise Report</span></a></li>
                                                    <li class="kt-menu__item {{ ($active == 'user-evaluation-analytical-report-employee') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{ route('user.evaluation.analytical.report.employee') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Employee wise Report</span></a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany
                                </ul>
                            </ul>
                        </div>
                    </li>
                @endcanany
                {{-- End appraisal--}}






                    {{-- Start Payroll --}}
                    @canany([_permission(\App\Utils\Permissions::ADMIN_SALARY_VIEW), _permission(\App\Utils\Permissions::ADMIN_SALARY_ADJUSTMENT_VIEW), _permission(\App\Utils\Permissions::ADMIN_SALARY_HOLD_VIEW), _permission(\App\Utils\Permissions::ADMIN_SALARY_BONUS_VIEW),_permission(\App\Utils\Permissions::ADMIN_KPI_VIEW), _permission(\App\Utils\Permissions::ADMIN_TAX_VIEW), _permission(\App\Utils\Permissions::ADMIN_PROVIDENT_FUND_VIEW), _permission(\App\Utils\Permissions::ADMIN_LOAN_VIEW), _permission(\App\Utils\Permissions::MANGE_SALARY_SETUP_VIEW), _permission(\App\Utils\Permissions::SALARY_HISTORY_VIEW),  _permission(\App\Utils\Permissions::SALARY_GENERATE_VIEW)])
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['admin-adjustment-bill-list','manage-salary', 'salary-summary', 'salary-history', 'bank-settings', 'salary-generate', 'payroll-setting-index', 'payroll-salary-setting-add', 'process-salary-setting-index', 'payroll.provident.fund.index', 'payroll.provident.fund.add', 'payroll.provident.fund.setting', 'payroll.provident.fund.statement', 'payroll-setting-create', 'payroll-setting-add','admin-application-history', 'admin-loan-history-status', 'admin-loan-statement-update', 'admin-loan-statement-history', 'admin-emi-application-history', 'admin-setting-loan-type', 'admin-setting-loan-interested', 'admin-setting-loan-type', 'admin-setting-loan-interested', 'admin-adjustment-list', 'admin-adjustment-statement', 'admin-adjustment-edit', 'admin-adjustment-create', 'admin-adjustment-type-list', 'admin-adjustment-type-edit', 'admin-adjustment-type-create', 'payroll.tax.index', 'payroll.tax.add', 'payroll.tax.setting', 'payroll.tax.statement', 'admin-bonus-list', 'admin-bonus-history', 'admin-salary-hold-list', 'admin-salary-hold-statement', 'admin-salary-hold-history', 'manage-employee-hours', 'manage-employee-hours-view', 'manage-employee-attendance', 'manage-employee-attendance-view', 'payroll-report-salary-status', 'payroll-report-process-salary-status', 'payroll-report-bank-salary-status', 'payroll-report-cheque-salary-status', 'payroll-report-hold-salary-status', 'payroll-report-all-salary-status', 'manage-employee-attendance-summary', 'manage-employee-attendance-summary-view', 'payroll-report-missing-salary-settings']) ? 'kt-menu__item--open' : ''}}"
                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                    <i class="kt-menu__link-icon la la-money"></i>
                    </span><span class="kt-menu__link-text">Payroll</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['salary-summary', 'payroll-report-salary-status', 'payroll-report-process-salary-status', 'payroll-report-bank-salary-status', 'payroll-report-cheque-salary-status', 'payroll-report-hold-salary-status', 'payroll-report-all-salary-status', 'payroll-report-missing-salary-settings']) ? 'kt-menu__item--open' : '' }}"
                                        aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                class="kt-menu__link-icon">
                                        <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                        </span><span class="kt-menu__link-text">Report</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                            <ul class="kt-menu__subnav">
                                                <li class="kt-menu__item {{ ($active == 'salary-summary')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                        href="{{ route('manage.salary.summary') }}" class="kt-menu__link "><i
                                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                            class="kt-menu__link-text">Summary</span></a></li>
                                                <li class="kt-menu__item {{ ($active == 'payroll-report-missing-salary-settings')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                        href="{{ route('report.payroll.all.missing.salary.settings') }}" class="kt-menu__link "><i
                                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Missing Salary Settings</span></a>
                                                </li>
                                                <li class="kt-menu__item {{ ($active == 'payroll-report-salary-status')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                        href="{{ route('report.payroll.salary.status') }}" class="kt-menu__link "><i
                                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Payment type</span></a>
                                                </li>
                                                <li class="kt-menu__item {{ ($active == 'payroll-report-process-salary-status')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                        href="{{ route('report.payroll.process.salary.status') }}" class="kt-menu__link "><i
                                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Process salary</span></a>
                                                </li>
                                                <li class="kt-menu__item {{ ($active == 'payroll-report-bank-salary-status')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                        href="{{ route('report.payroll.bank.salary.status') }}" class="kt-menu__link "><i
                                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Bank salary</span></a>
                                                </li>
                                                <li class="kt-menu__item {{ ($active == 'payroll-report-hold-salary-status')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                        href="{{ route('report.payroll.hold.salary.status') }}" class="kt-menu__link "><i
                                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Hold salary</span></a>
                                                </li>
                                                <li class="kt-menu__item {{ ($active == 'payroll-report-cheque-salary-status')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                        href="{{ route('report.payroll.cheque.salary.status') }}" class="kt-menu__link "><i
                                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Cheque salary</span></a>
                                                </li>
                                                <li class="kt-menu__item {{ ($active == 'payroll-report-all-salary-status')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                        href="{{ route('report.payroll.all.salary.status') }}" class="kt-menu__link "><i
                                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">All salary</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="kt-menu__subnav">
                                    @canany([_permission(\App\Utils\Permissions::ADMIN_SALARY_VIEW), _permission(\App\Utils\Permissions::MANGE_SALARY_SETUP_VIEW), _permission(\App\Utils\Permissions::SALARY_HISTORY_VIEW),  _permission(\App\Utils\Permissions::SALARY_GENERATE_VIEW)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['manage-salary', 'salary-settings', 'salary-generate', 'salary-history', 'bank-settings']) ? 'kt-menu__item--open' : '' }}"
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">
                                    <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                    </span><span class="kt-menu__link-text">Salary</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @can(_permission(\App\Utils\Permissions::MANGE_SALARY_SETUP_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'manage-salary')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('manage.salary.list.view') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                    class="kt-menu__link-text">Manage Salary</span></a></li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::SALARY_GENERATE_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'salary-generate')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('manage.salary.create') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Generate</span></a>
                                                        </li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::SALARY_HISTORY_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'salary-history')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('manage.salary.history') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                    class="kt-menu__link-text">History</span></a>
                                                        </li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_SALARY_CREATE))
                                                        <li class="kt-menu__item {{ ($active == 'bank-settings')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('add.new.bank') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Bank Settings</span></a>
                                                        </li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_SALARY_CREATE))
                                                        <li class="kt-menu__item {{ ($active == 'salary-settings')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('salarySettings') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Breakdown Settings</span></a>
                                                        </li>@endcan
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany
                                </ul>
{{--                                <ul class="kt-menu__subnav">--}}
{{--                                    @canany([ 'Role View', 'Role Create', 'Permission View', 'Permission Create'])--}}
{{--                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['salary-history']) ? 'kt-menu__item--open' : '' }}"--}}
{{--                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span--}}
{{--                                                    class="kt-menu__link-icon">--}}
{{--                                    <i class="kt-menu__link-icon flaticon-calendar-2"></i>--}}
{{--                                    </span><span class="kt-menu__link-text">Salary</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>--}}
{{--                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>--}}
{{--                                                <ul class="kt-menu__subnav">--}}

{{--                                                    @can('Role View')--}}
{{--                                                        <li class="kt-menu__item {{ ($active == 'salary')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a--}}
{{--                                                                href="{{ route('manage.salary.create') }}" class="kt-menu__link "><i--}}
{{--                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Generate</span></a>--}}
{{--                                                        </li>@endcan--}}
{{--                                                    @can('Role View')--}}
{{--                                                        <li class="kt-menu__item {{ ($active == 'salary-history')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a--}}
{{--                                                                href="{{ route('manage.salary.history') }}" class="kt-menu__link "><i--}}
{{--                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span--}}
{{--                                                                    class="kt-menu__link-text">History</span></a></li>@endcan--}}
{{--                                                    @can('Role View')--}}
{{--                                                        <li class="kt-menu__item {{ ($active == 'salary')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a--}}
{{--                                                                href="{{ route('manage.salary.history.individual') }}" class="kt-menu__link "><i--}}
{{--                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Individual History</span></a>--}}
{{--                                                        </li>@endcan--}}
{{--                                                </ul>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}
{{--                                    @endcanany--}}
{{--                                </ul>--}}

                                <ul class="kt-menu__subnav">
                                    @canany([ 'Role View', 'Role Create', 'Permission View', 'Permission Create'])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['payroll-setting-index', 'payroll-setting-create', 'payroll-setting-add']) ? 'kt-menu__item--open' : '' }}"
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">
                            <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                            </span><span class="kt-menu__link-text">KPI</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @can('Role View')
                                                        <li class="kt-menu__item {{ ($active == 'payroll-setting-index')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('kpi.setting.index') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">KPI History</span></a>
                                                        </li>@endcan
                                                    @can('Permission View')
                                                        <li class="kt-menu__item {{ ($active == 'payroll-setting-create')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('kpi.setting.create') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">KPI CSV Upload</span></a>
                                                        </li>@endcan
                                                    @can('Permission View')
                                                        <li class="kt-menu__item {{ ($active == 'payroll-setting-add')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('kpi.setting.add') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                    class="kt-menu__link-text">Add KPI</span></a></li>@endcan
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany
                                </ul>
                            </div>
                            {{-- <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @canany([ _permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_CREATE)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['payroll-salary-setting-add', 'process-salary-setting-index']) ? 'kt-menu__item--open' : '' }}"
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">
                                     <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                    </span><span class="kt-menu__link-text">Proc. Salary Settings</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @can('Role View')
                                                        <li class="kt-menu__item {{ ($active == 'process-salary-setting-index')? 'kt-menu__item--active' : '' }} "
                                                            aria-haspopup="true"><a href="{{ route('process.payment.setting.index') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Settings List</span></a>
                                                        </li>@endcan
                                                    @can('Permission View')
                                                        <li class="kt-menu__item {{ ($active == 'payroll-salary-setting-add')? 'kt-menu__item--active' : '' }} "
                                                            aria-haspopup="true"><a href="{{ route('process.payment.setting.add') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Add New Settings </span></a>
                                                        </li>@endcan
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany
                                </ul>
                            </div> --}}
                            <div class="kt-menu__submenu ">
                                <span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @canany([ _permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_CREATE), _permission(\App\Utils\Permissions::ADMIN_EMPLOYEE_HOUR_VIEW)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['manage-employee-hours', 'manage-employee-hours-view']) ? 'kt-menu__item--open' : '' }}"
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">
                                     <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                    </span><span class="kt-menu__link-text">Employee Hours</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_EMPLOYEE_HOUR_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'manage-employee-hours')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('manage.salary.employee.hours') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                    class="kt-menu__link-text">History</span></a></li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_EMPLOYEE_HOUR_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'manage-employee-hours-view')? 'kt-menu__item--active' : '' }} "
                                                            aria-haspopup="true"><a href="{{ route('upload.salary.employee.hours.view') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Upload data</span></a>
                                                        </li>@endcan
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany
                                </ul>
                            </div>

                            <div class="kt-menu__submenu ">
                                <span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @canany([ _permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_CREATE), _permission(\App\Utils\Permissions::ADMIN_EMPLOYEE_HOUR_VIEW)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['manage-employee-attendance', 'manage-employee-attendance-view']) ? 'kt-menu__item--open' : '' }}"
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">
                                     <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                    </span><span class="kt-menu__link-text">Employee Attendance</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_EMPLOYEE_HOUR_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'manage-employee-attendance')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('manage.salary.employee.attendance') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                    class="kt-menu__link-text">History</span></a></li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_EMPLOYEE_HOUR_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'manage-employee-attendance-view')? 'kt-menu__item--active' : '' }} "
                                                            aria-haspopup="true"><a href="{{ route('upload.salary.employee.attendance.view') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Upload data</span></a>
                                                        </li>@endcan
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany
                                </ul>
                            </div>


                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @canany([ _permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_CREATE)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['manage-employee-attendance-summary', 'manage-employee-attendance-summary-view']) ? 'kt-menu__item--open' : '' }}"
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">
                                     <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                    </span><span class="kt-menu__link-text">Attendance Summary</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @can('Role View')
                                                        <li class="kt-menu__item {{ ($active == 'manage-employee-attendance-summary')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('manage.salary.employee.attendance-summary') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                    class="kt-menu__link-text">History</span></a></li>@endcan
                                                    @can('Permission View')
                                                        <li class="kt-menu__item {{ ($active == 'manage-employee-attendance-summary-view')? 'kt-menu__item--active' : '' }} "
                                                            aria-haspopup="true"><a href="{{ route('upload.salary.employee.attendance-summary.view') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Upload data</span></a>
                                                        </li>@endcan
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany
                                </ul>
                            </div>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @canany([ 'Role View', 'Role Create', 'Permission View', 'Permission Create'])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['payroll.provident.fund.index', 'payroll.provident.fund.add', 'payroll.provident.fund.setting', 'payroll.provident.fund.statement']) ? 'kt-menu__item--open' : '' }}"
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">
                                     <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                    </span><span class="kt-menu__link-text">Provident Fund</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @can('Role View')
                                                        <li class="kt-menu__item {{ ($active == 'payroll.provident.fund.index')? 'kt-menu__item--active' : '' }} "
                                                            aria-haspopup="true"><a href="{{ route('payroll.provident.fund.index') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                    class="kt-menu__link-text">History</span></a></li>@endcan
                                                    @can('Permission View')
                                                        {{--<li class="kt-menu__item {{ ($active == 'payroll.provident.fund.add')? 'kt-menu__item--active' : '' }} "
                                                            aria-haspopup="true"><a href="{{ route('payroll.provident.fund.add') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                    class="kt-menu__link-text">Add New</span></a></li>--}}@endcan
                                                    @can('Permission View')
                                                        <li class="kt-menu__item {{ ($active == 'payroll.provident.fund.statement')? 'kt-menu__item--active' : '' }} "
                                                            aria-haspopup="true"><a href="{{ route('payroll.provident.fund.statement') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Statement</span></a>
                                                        </li>@endcan
                                                    @can('Permission View')
                                                        <li class="kt-menu__item {{ ($active == 'payroll.provident.fund.setting')? 'kt-menu__item--active' : '' }} "
                                                            aria-haspopup="true"><a href="{{ route('payroll.provident.fund.setting') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                    class="kt-menu__link-text">Settings</span></a></li>@endcan
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany
                                </ul>
                            </div>

                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @canany([ _permission(\App\Utils\Permissions::ADMIN_TAX_VIEW)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['payroll.tax.index', 'payroll.tax.add', 'payroll.tax.setting', 'payroll.tax.statement']) ? 'kt-menu__item--open' : '' }}"
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">
                                     <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                    </span><span class="kt-menu__link-text">Tax</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_TAX_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'payroll.tax.index')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('payroll.tax.index') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                    class="kt-menu__link-text">History</span></a></li>@endcan
                                                    @can('Permission View')
                                                        {{--<li class="kt-menu__item {{ ($active == 'payroll.tax.add')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('payroll.tax.add') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                    class="kt-menu__link-text">Add New</span></a></li>--}}@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_TAX_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'payroll.tax.statement')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('payroll.tax.statement') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Statement</span></a>
                                                        </li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_TAX_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'payroll.tax.setting')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('payroll.tax.setting') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                    class="kt-menu__link-text">Setting</span></a></li>@endcan
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany
                                </ul>
                            </div>


                            {{--                        start loan module--}}

                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">

                                    @canany([ _permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_CREATE), _permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW), _permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_CREATE)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['admin-application-history', 'admin-loan-history-status', 'admin-loan-statement-update', 'admin-loan-statement-history', 'admin-emi-application-history', 'admin-setting-loan-type', 'admin-setting-loan-interested', 'admin-setting-loan-type', 'admin-setting-loan-interested']) ? 'kt-menu__item--open' : ''}}"
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">
                <i class="kt-menu__link-icon flaticon-settings"></i>
                </span><span class="kt-menu__link-text">Loan</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @canany([ 'admin-application-history', 'admin-loan-history-status'])
                                                        <li class="kt-menu__item {{ ($active == 'admin-application-history')? 'kt-menu__item--active' : '' }} "
                                                            aria-haspopup="true"><a href="{{ route('admin.loan.application.history') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Loan Application Request</span></a>
                                                        </li>
                                                        <li class="kt-menu__item {{ ($active == 'admin-loan-history-status')? 'kt-menu__item--active' : '' }} "
                                                            aria-haspopup="true"><a href="{{ route('admin.loan.status.history') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Loan History</span></a>
                                                        </li>
                                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['admin-loan-statement-update', 'admin-loan-statement-history']) ? 'kt-menu__item--open' : '' }}"
                                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;"
                                                                                                                       class="kt-menu__link kt-menu__toggle"><span
                                                                    class="kt-menu__link-icon">
                                                    <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                                    </span><span class="kt-menu__link-text">Monthly Loan</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                                <ul class="kt-menu__subnav">
                                                                    @can(_permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW))
                                                                        <li class="kt-menu__item {{ ($active == 'admin-loan-statement-update')? 'kt-menu__item--active' : '' }} "
                                                                            aria-haspopup="true"><a href="{{ route('admin.loan.statement.update') }}" class="kt-menu__link "><i
                                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                                    class="kt-menu__link-text">Loan Statement Update</span></a></li>@endcan
                                                                    @can(_permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW))
                                                                        <li class="kt-menu__item {{ ($active == 'admin-loan-statement-history')? 'kt-menu__item--active' : '' }} "
                                                                            aria-haspopup="true"><a href="{{ route('admin.loan.statement.history') }}" class="kt-menu__link "><i
                                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                                    class="kt-menu__link-text">Loan Statement History</span></a></li>@endcan
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endcanany
                                                </ul>
                                            </div>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @canany([ _permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_CREATE)])
                                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['admin-emi-application-history']) ? 'kt-menu__item--open' : '' }}"
                                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;"
                                                                                                                       class="kt-menu__link kt-menu__toggle"><span
                                                                    class="kt-menu__link-icon">
                                 <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                </span><span class="kt-menu__link-text">EMI Application</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                                <ul class="kt-menu__subnav">
                                                                    @can(_permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW))
                                                                        <li class="kt-menu__item {{ ($active == 'admin-emi-application-history')? 'kt-menu__item--active' : '' }} "
                                                                            aria-haspopup="true"><a href="{{ route('admin.loan.emi.application.history') }}" class="kt-menu__link "><i
                                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                                    class="kt-menu__link-text">Hisrory/List View</span></a></li>@endcan
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endcanany
                                                </ul>
                                            </div>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @canany([ _permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_CREATE)])
                                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['admin-setting-loan-type', 'admin-setting-loan-interested']) ? 'kt-menu__item--open' : '' }}"
                                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;"
                                                                                                                       class="kt-menu__link kt-menu__toggle"><span
                                                                    class="kt-menu__link-icon">
                                 <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                </span><span class="kt-menu__link-text">Setting</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                                <ul class="kt-menu__subnav">
                                                                    @can(_permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW))
                                                                        <li class="kt-menu__item {{ ($active == 'admin-setting-loan-type')? 'kt-menu__item--active' : '' }} "
                                                                            aria-haspopup="true"><a href="{{ route('admin.loan.setting.loan.type') }}" class="kt-menu__link "><i
                                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                                    class="kt-menu__link-text">Loan Type</span></a></li>@endcan
                                                                    @can(_permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW))
                                                                        <li class="kt-menu__item {{ ($active == 'admin-setting-loan-interested')? 'kt-menu__item--active' : '' }} "
                                                                            aria-haspopup="true"><a href="{{ route('admin.loan.setting.loan.interested', ['id'=>1]) }}"
                                                                                                    class="kt-menu__link "><i
                                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                                    class="kt-menu__link-text">Interested</span></a></li>@endcan
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endcanany
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany

                                </ul>
                            </div>
                            {{--                        end loan module--}}


                            {{--                        start adjustment module--}}
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">

                                    @canany([ _permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_CREATE), _permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW), _permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_CREATE),  _permission(\App\Utils\Permissions::ADMIN_SALARY_ADJUSTMENT_VIEW)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['admin-adjustment-list', 'admin-adjustment-edit', 'admin-adjustment-create', 'admin-adjustment-type-list', 'admin-adjustment-type-edit', 'admin-adjustment-type-create', 'admin-adjustment-statement', 'admin-adjustment-bill-list']) ? 'kt-menu__item--open' : ''}}"
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">
                                    <i class="kt-menu__link-icon flaticon-settings"></i>
                                    </span><span class="kt-menu__link-text">Adjustment</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @canany([_permission(\App\Utils\Permissions::ADMIN_SALARY_ADJUSTMENT_VIEW)])
                                                        <li class="kt-menu__item {{ ($active == 'admin-adjustment-list')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('payroll.adjustment.index') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Adjustment History</span></a>
                                                        </li>
                                                        <li class="kt-menu__item {{ ($active == 'admin-adjustment-statement')? 'kt-menu__item--active' : '' }} "
                                                            aria-haspopup="true"><a href="{{ route('payroll.adjustment.statement') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Adjustment Statement</span></a>
                                                        </li>
                                                    @endcanany
                                                </ul>
                                            </div>

                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @canany([ _permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_CREATE)])
                                                        @can(_permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW))
                                                                            <li class="kt-menu__item {{ ($active == 'admin-adjustment-bill-list')? 'kt-menu__item--active' : '' }} "
                                                                                aria-haspopup="true"><a href="{{ route('mobilebill.adjustment.list') }}" class="kt-menu__link "><i
                                                                                        class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                                        class="kt-menu__link-text">CSV Upload</span></a></li>
                                                        @endcan
                                                    @endcanany
                                                </ul>
                                            </div>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @canany([ _permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_CREATE)])
                                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['admin-adjustment-type-list', 'admin-adjustment-type-edit', 'admin-adjustment-type-create']) ? 'kt-menu__item--open' : '' }}"
                                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;"
                                                                                                                       class="kt-menu__link kt-menu__toggle"><span
                                                                    class="kt-menu__link-icon">
                                                     <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                                    </span><span class="kt-menu__link-text">Adjustment Type</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                                <ul class="kt-menu__subnav">
                                                                    @can(_permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW))
                                                                        <li class="kt-menu__item {{ ($active == 'admin-adjustment-type-list')? 'kt-menu__item--active' : '' }} "
                                                                            aria-haspopup="true"><a href="{{ route('payroll.adjustment.type.index') }}" class="kt-menu__link "><i
                                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                                    class="kt-menu__link-text">Adjustment Type List</span></a></li>@endcan
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endcanany
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany

                                </ul>
                            </div>
                            {{--                        end adjustment module--}}


                            {{--                        start salary hold module--}}
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @canany([ _permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_CREATE), _permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW), _permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_CREATE)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['admin-bonus-list', 'admin-bonus-history']) ? 'kt-menu__item--open' : ''}}"
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">
                                    <i class="kt-menu__link-icon flaticon-settings"></i>
                                    </span><span class="kt-menu__link-text">Bonus</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @canany([ 'admin-loan-list', 'admin-loan-edit', 'admin-loan-create'])
                                                        <li class="kt-menu__item {{ ($active == 'admin-bonus-list')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('payroll.bonus.index') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Bonus List</span></a>
                                                        </li>
                                                    @endcanany
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany

                            </ul>
                        </div>

                            {{--                        end salary hold module --}}


                            {{--                        start salary hold module --}}
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @canany([ _permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_CREATE), _permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW), _permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_CREATE), _permission(\App\Utils\Permissions::ADMIN_SALARY_HOLD_VIEW)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['admin-salary-hold-list', 'admin-salary-hold-statement', 'admin-salary-hold-history']) ? 'kt-menu__item--open' : ''}}"
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">
                                    <i class="kt-menu__link-icon flaticon-settings"></i>
                                    </span><span class="kt-menu__link-text">Salary Hold</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @canany([ _permission(\App\Utils\Permissions::ADMIN_SALARY_HOLD_VIEW)])
                                                        <li class="kt-menu__item {{ ($active == 'admin-salary-hold-list')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('payroll.salary.hold.index') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Salary Hold List</span></a>
                                                        </li>
                                                        <li class="kt-menu__item {{ ($active == 'admin-salary-hold-statement')? 'kt-menu__item--active' : '' }} "
                                                            aria-haspopup="true"><a href="{{ route('payroll.salary.hold.statement') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Salary Hold Statement</span></a>
                                                        </li>
                                                    @endcanany
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany

                                </ul>
                            </div>
                            {{--                        end salary hold module --}}


                        </li>



                    @endcanany
                    {{-- End Payroll --}}

                    @can(_permission(\App\Utils\Permissions::EMPLOYEE_LIST_VIEW))

                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['Leave-report', 'general-report', 'admin-leave-status', 'admin-leave-details', 'employee-attendance', 'employeeMissingReport', 'account-completion-report', 'empoyee-data-report', 'team-Leave-report', 'payroll-report-summary', 'missing-report-employee-hour-csv', 'missing-report-employee-attendance-csv', 'missing-report-kpi-csv', 'missing-report-tax-csv', 'missing-report-pf-csv', 'broadcast-setting', 'broadcast-history', 'expired-probation', 'expired-contractual']) ? 'kt-menu__item--open' : ''}} " aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                        <i class="kt-menu__link-icon flaticon-graphic"></i>
                        </span><span class="kt-menu__link-text">Report</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    {{-- <li class="kt-menu__item {{ ($active == 'empoyee-data-report')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('Admin.Report.employee-data') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Employee  Data Report</span></a>
                                    </li> --}}
                                    <li class="kt-menu__item {{ ($active == 'account-completion-report')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('Admin.Report.account-completion') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Account completion Report</span></a>
                                    </li>
                                    <li class="kt-menu__item {{ ($active == 'employeeMissingReport')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                        href="{{ route('Admin.Report.missing-data') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Missing Data Report</span></a>
                                    </li>
                                    <li class="kt-menu__item {{ ($active == 'general-report')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('general.report') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">General Report</span></a>
                                    </li>
                                    <li class="kt-menu__item {{ ($active == 'Leave-report') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a
                                            href="{{ route('Admin.Leave.report.view') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Individual Leave Reports</span></a>
                                    </li>
                                    <li class="kt-menu__item {{ ($active == 'team-Leave-report') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a
                                            href="{{ route('Admin.Leave.team.report.view') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                class="kt-menu__link-text">Leave Use Report</span></a></li>
                                    {{--                                    <li class="kt-menu__item {{ ($active == 'admin-leave-status')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.leave.status') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Leave Status</span></a></li>--}}
                                    <li class="kt-menu__item {{ ($active == 'employee-attendance') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('employee.attendance.view') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Employee Atteandance</span></a>
                                    </li>

                                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['missing-report-employee-hour-csv', 'missing-report-employee-attendance-csv', 'missing-report-kpi-csv', 'missing-report-tax-csv', 'missing-report-pf-csv']) ? 'kt-menu__item--open' : ''}} "
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">

                                    <i class="kt-menu__link-icon fas fa-exclamation-triangle"></i>
                                    </span><span class="kt-menu__link-text">Employee ID Missing</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                            <ul class="kt-menu__subnav">
                                                <!-- @can(_permission(\App\Utils\Permissions::MANGE_SALARY_SETUP_VIEW)) -->
                                                    <li class="kt-menu__item {{ ($active == 'missing-report-employee-hour-csv')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                            href="{{ route('missing.report.employee.hour.csv') }}" class="kt-menu__link "><i
                                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                class="kt-menu__link-text">Employee Hour</span></a>
                                                    </li>

                                                    <li class="kt-menu__item {{ ($active == 'missing-report-employee-attendance-csv')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                            href="{{ route('missing.report.employee.attendance.csv') }}" class="kt-menu__link "><i
                                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                class="kt-menu__link-text">Employee Attendance</span></a>
                                                    </li>

                                                    <li class="kt-menu__item {{ ($active == 'missing-report-kpi-csv')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                            href="{{ route('missing.report.kpi.csv') }}" class="kt-menu__link "><i
                                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                class="kt-menu__link-text">KPI</span></a>
                                                    </li>


                                                    {{-- <li class="kt-menu__item {{ ($active == 'missing-report-pf-csv')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                            href="{{ route('missing.report.pf.csv') }}" class="kt-menu__link "><i
                                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                class="kt-menu__link-text">PF</span></a>
                                                    </li>

                                                    <li class="kt-menu__item {{ ($active == 'missing-report-tax-csv')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                            href="{{ route('missing.report.tax.csv') }}" class="kt-menu__link "><i
                                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                class="kt-menu__link-text">Tax</span></a>
                                                    </li> --}}

                                                <!-- @endcan -->
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['broadcast-setting', 'broadcast-history']) ? 'kt-menu__item--open' : ''}} "
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">
                                    <i class="kt-menu__link-icon fas fa-exclamation-triangle"></i>
                                    </span><span class="kt-menu__link-text">Broadcast</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                            <ul class="kt-menu__subnav">
                                                <!-- @can(_permission(\App\Utils\Permissions::MANGE_SALARY_SETUP_VIEW)) -->
                                                    <li class="kt-menu__item {{ ($active == 'broadcast-setting')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                            href="{{ route('broadcast.setting') }}" class="kt-menu__link "><i
                                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                class="kt-menu__link-text">Settings</span></a>
                                                    </li>
                                                    <!-- <li class="kt-menu__item {{ ($active == 'broadcast-history')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                            href="{{ route('broadcast.history') }}" class="kt-menu__link "><i
                                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                class="kt-menu__link-text">History</span></a>
                                                    </li> -->
                                                <!-- @endcan -->
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['expired-probation', 'expired-contractual']) ? 'kt-menu__item--open' : ''}} "
                                    aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                            class="kt-menu__link-icon">
                                    <i class="kt-menu__link-icon fas fa-exclamation-triangle"></i>
                                    </span><span class="kt-menu__link-text">Upcoming</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                            <ul class="kt-menu__subnav">
                                                <li class="kt-menu__item {{ ($active == 'expired-contractual')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                        href="{{ route('expired.contractual') }}" class="kt-menu__link "><i
                                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                            class="kt-menu__link-text">Expired Contractual</span></a>
                                                </li>
                                                <li class="kt-menu__item {{ ($active == 'expired-probation')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                        href="{{ route('expired.probation') }}" class="kt-menu__link"><i
                                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                            class="kt-menu__link-text">Expired Probation</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan


                    {{-- Start Employee Closing--}}
                    @canany([_permission(\App\Utils\Permissions::EMPLOYEE_CLOSING_SEPARATION_VIEW), _permission(\App\Utils\Permissions::EMPLOYEE_CLOSING_SEPARATION_CREATE), _permission(\App\Utils\Permissions::EMPLOYEE_CLOSING_REPORT_VIEW), _permission(\App\Utils\Permissions::EMPLOYEE_CLOSING_SETTING_VIEW)])
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ (in_array($active, ['employee-termination','admin-clearance-checklist', 'request-to-clearance-list', 'admin-employee-interview', 'admin-employee-interview-answer', 'request-to-clearance-list', 'closing-attrition-report', 'clearance-status-report', 'fnf-report', 'admin-closing-dashboard']) ? 'kt-menu__item--open': '') }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                        <i class="kt-menu__link-icon fas fa-user-times"></i>
                        </span><span class="kt-menu__link-text">Employee Closing</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">

                                    {{--<li class="kt-menu__item {{ ($active == 'employee-termination')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.employee.termination') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Employee Separation</span></a></li>--}}
                                    @can(_permission(\App\Utils\Permissions::EMPLOYEE_CLOSING_SEPARATION_VIEW))<li class="kt-menu__item {{ ($active == 'admin-closing-dashboard')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.closing.dashboard') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Dashboard</span></a></li>@endcan
                                    @can(_permission(\App\Utils\Permissions::EMPLOYEE_CLOSING_SEPARATION_VIEW))<li class="kt-menu__item {{ ($active == 'employee-termination')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.employee.termination') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Emergency Separation</span></a></li>@endcan


                                    {{--Start Employee closing reports--}}
                                    @can(_permission(\App\Utils\Permissions::EMPLOYEE_CLOSING_REPORT_VIEW))
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ (in_array($active, ['request-to-clearance-list', 'closing-attrition-report', 'clearance-status-report', 'fnf-report']) ? 'kt-menu__item--open': '') }}"
                                        aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                class="kt-menu__link-icon">
                                    <i class="kt-menu__link-icon flaticon-graphic"></i>
                                    </span><span class="kt-menu__link-text">Reports</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                            <ul class="kt-menu__subnav">
                                                <li class="kt-menu__item {{ ($active == 'request-to-clearance-list')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.clearance.checklist.list') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Request Status</span></a></li>
                                                <li class="kt-menu__item {{ ($active == 'closing-attrition-report')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.closing.attrition.report') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Attrition Report</span></a></li>
                                                <li class="kt-menu__item {{ ($active == 'clearance-status-report')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.clearance.status.report') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Clearance Status</span></a></li>
                                                <li class="kt-menu__item {{ ($active == 'fnf-report')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('admin.fnf.report') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">FNF Report</span></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    @endcan
                                    {{--End Employee closing reports--}}
                                    {{--<li class="kt-menu__item {{ ($active == 'request-to-it') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{ route('request.clearance.it') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Request to IT</span></a></li>
                                    <li class="kt-menu__item {{ ($active == 'request-to-admin') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{ route('request.clearance.admin') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Request to Admin</span></a></li>
                                    <li class="kt-menu__item {{ ($active == 'request-to-hr') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('request.clearance.hr') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Request to HR</span></a></li>--}}

                                    @can(_permission(\App\Utils\Permissions::EMPLOYEE_CLOSING_SETTING_VIEW))
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ (in_array($active, ['admin-clearance-checklist', 'admin-employee-interview', 'admin-employee-interview-answer']) ? 'kt-menu__item--open': '') }}"
                                        aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                class="kt-menu__link-icon">
                                    <i class="kt-menu__link-icon flaticon-settings"></i>
                                    </span><span class="kt-menu__link-text">Setting</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                            <ul class="kt-menu__subnav">
                                                <li class="kt-menu__item {{ ($active == 'admin-clearance-checklist')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                        href="{{ route('admin.clearance.checklist', ['id'=>1]) }}" class="kt-menu__link "><i
                                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Clearance Checklist</span></a>
                                                </li>
                                                {{--Start employee evaluation setup--}}
                                                <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['admin-employee-interview', 'admin-employee-interview-answer']) ? 'kt-menu__item--open' : ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                                <i class="kt-menu__link-icon flaticon-cogwheel-2"></i>
                                                </span><span class="kt-menu__link-text">Exit Interview Setting</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                        <ul class="kt-menu__subnav">
                                                            <li class="kt-menu__item {{ ($active == 'admin-employee-interview') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{ route('admin.employee.interview') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Questions</span></a></li>
                                                            <li class="kt-menu__item {{ ($active == 'admin-employee-interview-answer') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{ route('admin.employee.interview.answer') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Answer</span></a></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                {{--End employee evaluation setup--}}
                                            </ul>
                                        </div>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcanany
                    {{-- End Employee Closing--}}


                    <!-- Asset -->
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['add.new.type', 'asset.index', 'asset.myRequisition','requisition', 'myAsset.index', 'asset.allocaiton', 'asset.requisition', 'asset.setting']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                        <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                    </span><span class="kt-menu__link-text">Asset</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                @can('Role View')
                                    <li class="kt-menu__item {{ ($active == 'add.new.type')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('add.new.type') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Types</span></a>
                                    </li>@endcan
                                @can('Permission View')
                                    <li class="kt-menu__item {{ ($active == 'asset.index')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('asset.index') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Assets</span></a>
                                    </li>@endcan
                                @can('Permission View')
                                    <li class="kt-menu__item {{ ($active == 'asset.allocaiton')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('asset.allocaiton') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Allocaitons</span></a>
                                    </li>@endcan
                                @can('Permission View')
                                    <li class="kt-menu__item {{ ($active == 'asset.requisition')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('asset.requisition') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Requisitions</span></a>
                                    </li>@endcan
                            </ul>
                        </div>
                    </li>

                    <!-- Resources -->
                    {{-- here it is khayrun vai --}}
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['resource-lib-list', 'resource-lib-trash']) ? 'kt-menu__item--open' : '' }}"
                        aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                        <i class="kt-menu__link-icon flaticon-folder"></i>
                    </span><span class="kt-menu__link-text">Resource Library</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                @can('Role View')
                                    <li class="kt-menu__item {{ ($active == 'resource-lib-list')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('resource.list') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">All files</span></a>
                                    </li>@endcan
                                @can('Permission View')
                                    <li class="kt-menu__item {{ ($active == 'resource-lib-trash')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('resource.trashes') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Archive</span></a>
                                    </li>@endcan
                            </ul>
                        </div>
                    </li>

                    {{-- Hiring Recruitment --}}
                    @can(_permission(\App\Utils\Permissions::EMPLOYEE_CLOSING_SETTING_VIEW))
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['hiring-recruitment-list']) ? 'kt-menu__item--open' : '' }}"
                        aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                            <i class="fas fa-briefcase"></i>
                    </span><span class="kt-menu__link-text">Hiring Request</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item {{ ($active == 'hiring-recruitment-list')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('admin.hiring.request.history') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Request List</span></a>
                                    </li>
                            </ul>
                        </div>
                    </li>
                    @endcan

                    {{-- settings --}}
                    @canany([ _permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_CREATE), _permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW), _permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_CREATE)])
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['manage-permission', 'manage-role','look-up-department', 'look-up-leave-reason', 'look-up-division' ,'look-up-designation', 'look-up-process', 'look-up-doc', 'look-up-process-segment', 'look-up-status','look-up-center', 'look-up-roster','look-up-leave', 'look-up-institute', 'look-up-holiday', 'look-up-nearbyLocation']) ? 'kt-menu__item--open' : ''}}"
                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                        <i class="kt-menu__link-icon flaticon-settings"></i>
                        </span><span class="kt-menu__link-text">Settings</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @canany([ _permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW), _permission(\App\Utils\Permissions::ADMIN_ROLE_CREATE), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW), _permission(\App\Utils\Permissions::ADMIN_PERMISSION_CREATE)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ ($active == 'manage-role') ? 'kt-menu__item--open' : (($active == 'manage-permission')? 'kt-menu__item--open' : '') }}"
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">
                                <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                </span><span class="kt-menu__link-text">Roles & Permission</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_ROLE_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'manage-role')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('settings.manage.role.view') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Manage Role</span></a>
                                                        </li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_PERMISSION_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'manage-permission')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('settings.manage.permission.view') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Manage Permission</span></a>
                                                        </li>@endcan
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany
                                    @canany([_permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW), _permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_CREATE)])
                                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['look-up-department','look-up-designation', 'look-up-division', 'look-up-process', 'look-up-doc', 'look-up-process-segment', 'look-up-status', 'look-up-center', 'look-up-roster', 'look-up-leave-reason', 'look-up-leave', 'look-up-institute', 'look-up-holiday','look-up-nearbyLocation']) ? 'kt-menu__item--open' : ''}}"
                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span
                                                    class="kt-menu__link-icon">
                                <i class="kt-menu__link-icon flaticon-cogwheel-2"></i>
                                </span><span class="kt-menu__link-text">General Settings</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                                <ul class="kt-menu__subnav">
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'look-up-division')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('settings.manage.division') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Division</span></a>
                                                        </li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'look-up-center')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('settings.manage.center') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                                    class="kt-menu__link-text">Center</span></a></li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'look-up-department')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('settings.manage.department') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Department</span></a>
                                                        </li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'look-up-process')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('settings.manage.process') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Processes</span></a>
                                                        </li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'look-up-process-segment')? 'kt-menu__item--active' : '' }} " aria-haspopup="true">
                                                            <a href="{{ route('settings.manage.process.segment') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Processes Segment</span></a>
                                                        </li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'look-up-designation')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('settings.manage.designation') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Designation</span></a>
                                                        </li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'look-up-status')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('settings.manage.employee.status') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Employee Status</span></a>
                                                        </li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'look-up-nearbyLocation')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('settings.manage.nearbyLocations') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Nearby Locations</span></a>
                                                        </li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'look-up-institute')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('settings.manage.institutes') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Institutes</span></a>
                                                        </li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'look-up-holiday')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('settings.manage.holidays') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Holidays</span></a>
                                                        </li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'look-up-leave-reason')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('settings.manage.leave.reason') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Leave Reason Setup</span></a>
                                                        </li>@endcan
                                                    @can(_permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'look-up-roster')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('settings.manage.roster') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Roster Time Slots Setup</span></a>
                                                        </li>@endcan
                                                    {{-- @can(_permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'look-up-leave')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('settings.manage.set.leave') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Leave Setup</span></a>
                                                        </li>@endcan --}}

                                                    @can(_permission(\App\Utils\Permissions::ADMIN_GENERAL_SETTINGS_VIEW))
                                                        <li class="kt-menu__item {{ ($active == 'look-up-doc')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                                                href="{{ route('settings.manage.document') }}" class="kt-menu__link "><i
                                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Letter & Document Setup</span></a>
                                                        </li>@endcan
                                                </ul>
                                            </div>
                                        </li>
                                    @endcanany

                                    {{--                        @canany(['Workflow Settings View', 'Workflow Settings Create'])--}}
                                    {{--                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here " aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">--}}
                                    {{--                            <i class="kt-menu__link-icon flaticon-network"></i>--}}
                                    {{--                            </span><span class="kt-menu__link-text">Workfolw Settings</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>--}}
                                    {{--                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>--}}
                                    {{--                                <ul class="kt-menu__subnav">--}}
                                    {{--                                    @can('Workflow Settings View')<li class="kt-menu__item {{ ($active == 'look-up-workflow-base-setup')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('settings.workflow.base.setup') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Base Setup</span></a></li>@endcan--}}
                                    {{--                                </ul>--}}
                                    {{--                            </div>--}}
                                    {{--                        </li>--}}
                                    {{--                        @endcanany--}}







                                </ul>
                            </div>
                        </li>
                    @endcanany




                {{-- menus for User roles --}}
                @elseif(auth()->user()->hasRole('User') && request()->session()->get('validateRole') == 'User')
                    <li class="kt-menu__item " aria-haspopup="true"><a href="{{ route('user.dashboard') }}" class="kt-menu__link "><i
                                class="kt-menu__link-icon flaticon-home"></i><span class="kt-menu__link-text">Dashboard</span></a></li>

                    {{-- Team --}}
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['change-request', 'exec-roster-upload','exec-attendance-upload', 'review-roster', 'team-leave-history', 'team-leave-status', 'leave-apply', 'team-leave-request', 'team-now-at-office']) ? 'kt-menu__item--open' : (($active == 'team-attendance')? 'kt-menu__item--open' : (($active == 'my-team-list')? 'kt-menu__item--open' : '')) }}"
                        aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                        <i class="kt-menu__link-icon la la-users"></i>
                    </span><span class="kt-menu__link-text">Team</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item {{ ($active == 'my-team-list')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                        href="{{ route('user.team.list.view') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                            class="kt-menu__link-text">My Teams</span></a></li>
                                @canany([_permission(\App\Utils\Permissions::USER_ROSTER_VIEW), _permission(\App\Utils\Permissions::USER_ROSTER_CREATE)])
                                    <li class="kt-menu__item {{ ($active == 'review-roster')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('user.roster.review.view') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Review Roster</span></a>
                                    </li>@endcanany


                                @can(_permission(\App\Utils\Permissions::TEAM_VIEW))
                                    <li class="kt-menu__item {{ ($active == 'change-request') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true">
                                        <a href="{{ route('user.attendance.change.approval') }}" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                            <span class="kt-menu__link-text">Att. Change Requests</span>
                                        </a>
                                    </li>
                                @endcan



                                @can(_permission(\App\Utils\Permissions::USER_ROSTER_CREATE))
                                    <li class="kt-menu__item {{ ($active == 'exec-roster-upload') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('user.roster.upload') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                class="kt-menu__link-text">CSV Roster Upload</span></a></li>@endcan
                                @can(_permission(\App\Utils\Permissions::USER_ATTENDANCE_CREATE))
                                    <li class="kt-menu__item {{ ($active == 'exec-attendance-upload') ? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('user.attendance.upload') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                class="kt-menu__link-text">CSV Attendance Upload</span></a></li>@endcan
                                @canany([_permission(\App\Utils\Permissions::TEAM_VIEW), _permission(\App\Utils\Permissions::SUPERVISOR_VIEW)])
                                    <li class="kt-menu__item {{ ($active == 'team-attendance')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('user.team.attandance.view') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Team Attendance</span></a>
                                    </li>@endcanany

                                
                                <li class="kt-menu__item {{ ($active == 'team-now-at-office')? 'kt-menu__item--active' : '' }} " aria-haspopup="true">
                                    <a href="{{ route('user.team.attandance.now.at.office.view') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Team - Now at Office</span></a>
                                </li>

                                @canany([_permission(\App\Utils\Permissions::TEAM_VIEW), _permission(\App\Utils\Permissions::SUPERVISOR_VIEW)])
                                    <li class="kt-menu__item {{ ($active == 'team-leave-request')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('leave.request') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                class="kt-menu__link-text">Team Leave Request</span></a></li>@endcanany
                                @canany([_permission(\App\Utils\Permissions::TEAM_VIEW), _permission(\App\Utils\Permissions::SUPERVISOR_VIEW)])
                                    <li class="kt-menu__item {{ ($active == 'team-leave-status')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('team.leave.status') }}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                class="kt-menu__link-text">Team Leave Status</span></a></li>@endcanany
                                @canany([_permission(\App\Utils\Permissions::TEAM_VIEW), _permission(\App\Utils\Permissions::SUPERVISOR_VIEW)])
                                    <li class="kt-menu__item {{ ($active == 'team-leave-history')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                            href="{{ route('team.leave.history') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                class="kt-menu__link-text">Team Leave History</span></a></li>@endcanany
                            </ul>
                        </div>
                    </li>


                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here
                                        {{ in_array($active, ['create-roster', 'revise-roster', 'user-attendance', 'user-hourly-attendance']) ? 'kt-menu__item--open' : '' }}"

                                            aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a
                            href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">

                        <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                    </span><span class="kt-menu__link-text">Roster</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span
                                            class="kt-menu__link-text">Roster</span></span></li>
                                    {{-- <li class="kt-menu__item {{ ($active == 'create-roster')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('user.roster.create.view') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Create Roster</span></a></li> --}}


                                {{-- <li class="kt-menu__item {{ ($active == 'revise-roster')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                        href="{{ route('user.roster.revise.view') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                            class="kt-menu__link-text">Revise Roster</span></a></li> --}}
                                <li class="kt-menu__item {{ ($active == 'user-attendance')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                        href="{{ route('user.attendance.view') }}" class="kt-menu__link "><i
                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">My Roster</span></a></li>
                                            {{-- <li class="kt-menu__item {{ ($active == 'user-hourly-attendance')? 'kt-menu__item--active' : '' }} " aria-haspopup="true">
                                                <a href="{{ route('user.hourly.attendance.view') }}" class="kt-menu__link ">
                                                <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Daily Attendance Details</span></a></li> --}}
                            </ul>
                        </div>
                    </li>

                    <!-- Asset -->
                    {{-- <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['add.new.type', 'asset.index', 'asset.myRequisition','requisition', 'myAsset.index', 'asset.allocaiton', 'asset.requisition', 'asset.setting']) ? 'kt-menu__item--open' : '' }}"
                        aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                        <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                        </span><span class="kt-menu__link-text">Asset</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item {{ ($active == 'myAsset.index')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                        href="{{ route('myAsset.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                            class="kt-menu__link-text">My Assets</span></a></li>
                                <li class="kt-menu__item {{ ($active == 'asset.myRequisition')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                        href="{{ route('asset.my.requisition') }}" class="kt-menu__link "><i
                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">My Requisitions</span></a></li>
                            </ul>
                        </div>
                    </li> --}}





                    {{-- leave --}}
                    <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['leave-dashboard', 'leave-details']) ? 'kt-menu__item--open' : ''  }} "
                        aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript: void(0);" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon"><i
                                    class="kt-menu__link-icon flaticon-user"></i>
                        </span><span class="kt-menu__link-text">Leave & Attendance</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item {{ ($active == 'leave-dashboard')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('leave.dashboard') }}"
                                                                                                                                                    class="kt-menu__link "><i
                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Attendance dashboard</span></a></li>
                                <li class="kt-menu__item {{ ($active == 'leave-details')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('leave.list') }}"
                                                                                                                                                    class="kt-menu__link "><i
                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">My Leave</span></a></li>

                            </ul>
                        </div>
                    </li>


                    {{-- user letter and doc panel start  --}}
                    {{-- <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['user-document-create', 'user-document-history', 'user-request-history']) ? 'kt-menu__item--open' : ''  }} "
                        aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                            <i class="fas fa-hdd"></i>
                        </span><span class="kt-menu__link-text">Letter and Documents</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item {{ ($active == 'user-document-create')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                        href="{{ route('employee.letter.and.documents') }}" class="kt-menu__link "><i
                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Request Doc & Letter</span></a>
                                </li>
                                <li class="kt-menu__item {{ ($active == 'user-request-history')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                        href="{{ route('employee.request.history') }}" class="kt-menu__link "><i
                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Request History</span></a></li>
                                <li class="kt-menu__item {{ ($active == 'user-document-history')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                        href="{{ route('employee.documents.history') }}" class="kt-menu__link "><i
                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Document History</span></a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}
                    {{-- user letter and doc panel end   --}}


                    {{-- user Notice and event start --}}
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['user-notice-board', 'user-event-calender']) ? 'kt-menu__item--open' : ''  }} "
                        aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                            <i class="fas fa-calendar-day"></i>
                        </span><span class="kt-menu__link-text">Notice and Event</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item {{ ($active == 'user-notice-board')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('employee.notice.board') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Notice Board</span></a></li>
                                <li class="kt-menu__item {{ ($active == 'user-event-calender')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('employee.event.calender') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Event Calendar</span></a></li>
                            </ul>
                        </div>
                    </li>
                {{-- user letter and doc panel end --}}

                {{-- user Resource Lib start --}}
                {{-- <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['user-resource-lib']) ? 'kt-menu__item--open' : ''  }} "
                    aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                    <i class="fas flaticon-folder"></i>
                    </span><span class="kt-menu__link-text">Resource Library</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item {{ ($active == 'user-resource-lib')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('employee.resource.library') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Resource Lib</span></a></li>
                        </ul>
                    </div>
                </li> --}}

                {{-- <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['salary-history']) ? 'kt-menu__item--open' : ''  }} "
                    aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                    <i class="fas fa-money-bill-alt"></i>
                    </span><span class="kt-menu__link-text">Payroll</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item {{ ($active == 'salary-history')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('manage.salary.employee.history') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Salary History</span></a></li>
                        </ul>
                    </div>
                </li> --}}

                {{-- Employee hour upload --}}
                @canany([_permission(\app\Utils\Permissions::EMPLOYEE_HOUR_UPLOAD_CREATE)])
                <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['manage-employee-hours', 'manage-employee-hours-view']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                <i class="fas fa-calendar-day"></i>
                </span><span class="kt-menu__link-text">Employee Hours Upload</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @can(_permission(\app\Utils\Permissions::EMPLOYEE_HOUR_UPLOAD_CREATE))
                                        <li class="kt-menu__item {{ ($active == 'manage-employee-hours')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                        href="{{ route('employee.manage.salary.employee.hours') }}" class="kt-menu__link "><i
                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                            class="kt-menu__link-text">History</span></a></li>@endcan
                                    @can(_permission(\app\Utils\Permissions::EMPLOYEE_HOUR_UPLOAD_CREATE))
                                        <li class="kt-menu__item {{ ($active == 'manage-employee-hours-view')? 'kt-menu__item--active' : '' }} "
                                            aria-haspopup="true"><a href="{{ route('employee.upload.salary.employee.hours.view') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Upload data</span></a>
                                        </li>@endcan
                                </ul>
                            </div>
                        </li>
                @endcanany


                {{-- Employee Attendance upload --}}
                @canany([_permission(\app\Utils\Permissions::EMPLOYEE_ATTENDANCE_UPLOAD_VIEW)])
                <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['manage-employee-attendance', 'manage-employee-attendance-view']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                <i class="fas fa-calendar-day"></i>
                </span><span class="kt-menu__link-text">Employee Attendance</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @can(_permission(\app\Utils\Permissions::EMPLOYEE_ATTENDANCE_UPLOAD_CREATE))
                                        <li class="kt-menu__item {{ ($active == 'manage-employee-attendance')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a
                                        href="{{ route('employee.manage.salary.employee.attendance') }}" class="kt-menu__link "><i
                                            class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                            class="kt-menu__link-text">History</span></a></li>@endcan
                                    @can(_permission(\app\Utils\Permissions::EMPLOYEE_ATTENDANCE_UPLOAD_CREATE))
                                        <li class="kt-menu__item {{ ($active == 'manage-employee-attendance-view')? 'kt-menu__item--active' : '' }} "
                                            aria-haspopup="true"><a href="{{ route('employee.upload.salary.employee.attendance.view') }}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Upload data</span></a>
                                        </li>@endcan
                                </ul>
                            </div>
                        </li>
                @endcanany

                {{-- user Resource Lib end --}}


                {{-- user locan panel start --}}
                {{--<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['user-apply-status', 'user-apply-loan', 'user-loan-emi-history', 'user-loan-emi-adjustment', 'user-loan-emi-reduce-application']) ? 'kt-menu__item--open' : ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                <i class="kt-menu__link-icon flaticon-settings"></i>
                </span><span class="kt-menu__link-text">Loan</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item {{ ($active == 'user-apply-loan')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('loam.application.create') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Apply for loan</span></a></li>
                            <li class="kt-menu__item {{ ($active == 'user-apply-status')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('loam.application.index') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Application status/History</span></a></li>
                            <li class="kt-menu__item {{ ($active == 'user-loan-emi-history')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('loam.user.emi.history') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">EMI History</span></a></li>
                        </ul>
                    </div>
                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                             <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['user-loan-emi-adjustment', 'user-loan-emi-reduce-application']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                             <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                             </span><span class="kt-menu__link-text">EMI adjustment</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        <li class="kt-menu__item {{ ($active == 'user-loan-emi-adjustment')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('loam.emi.adjustment') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Hisrory/List</span></a></li>
                                        <li class="kt-menu__item {{ ($active == 'user-loan-emi-reduce-application')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('loam.emi.reduce.application') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Application Form</span></a></li>
                                    </ul>
                                </div>
                             </li>
                        </ul>
                    </div>
                </li>--}}
                {{-- user loan panel end --}}




                {{-- user locan panel start --}}
                <li style="display: none" class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['fnf-report','user-final-closing-request-to-hr','employee-evaluation','user-closing-list', 'team-closing-request', 'request-to-clearance', 'user-request-to-hr', 'own-department-to-clearance']) ? 'kt-menu__item--open' : ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                    <i class="kt-menu__link-icon fas fa-user-times"></i>
                    </span><span class="kt-menu__link-text">Closing</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item {{ ($active == 'user-closing-list')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('user.closing.list') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Apply for Closing</span></a></li>
                                @canany([_permission(\App\Utils\Permissions::TEAM_VIEW), _permission(\App\Utils\Permissions::SUPERVISOR_VIEW)]) {{--It get supervisor or team lead--}}
                                    <li class="kt-menu__item {{ ($active == 'team-closing-request')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('user.closing.request') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">User Closing Request (TL/SP)</span></a></li>
                                <li class="kt-menu__item {{ ($active == 'own-department-to-clearance') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{ route('own.department.to.clearance') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Own Department Clearance</span></a></li>
                                @endcanany


                                <!-- @php
                                    $closingUserFromClosingSetting = DB::table('closing_clearance_settings')->select('hr_hod_id', 'hr_in_charge_id', 'it_hod_id', 'it_in_charge_id', 'admin_hod_id', 'admin_in_charge_id', 'accounts_hod_id', 'accounts_in_charge_id')->get();

                                    /*$ownDepartmentClearanceHod = DB::table('departments')->select('id')
                                    ->where('own_hod_id', auth()->user()->employee_id)
                                    ->get()->pluck(['id']);

                                    $ownDepartmentClearanceIncharge = DB::table('departments')->select('id')
                                    ->where('own_in_charge_id', auth()->user()->employee_id)
                                    ->get()->pluck(['id']);*/

                                    $userListArr = (array) $closingUserFromClosingSetting[0] ?? [];

                                @endphp -->


                                @canany([
                                 _permission(\App\Utils\Permissions::HR_HOD_VIEW),
                                 _permission(\App\Utils\Permissions::HR_IN_CHARGE_VIEW),
                                 _permission(\App\Utils\Permissions::IT_HOD_VIEW),
                                 _permission(\App\Utils\Permissions::IT_IN_CHARGE_VIEW),
                                 _permission(\App\Utils\Permissions::ADMIN_HOD_VIEW),
                                 _permission(\App\Utils\Permissions::ADMIN_IN_CHARGE_VIEW),
                                 _permission(\App\Utils\Permissions::ACCOUNTS_HOD_VIEW),
                                 _permission(\App\Utils\Permissions::ACCOUNTS_IN_CHARGE_VIEW)
                                 ]) {{--It get admin, hr, it and accounts department--}}
                                   <li class="kt-menu__item {{ ($active == 'request-to-clearance')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('request.clearance.clearance') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Request to Clearance</span></a></li>

                                   <li class="kt-menu__item {{ ($active == 'fnf-report')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('fnf.report') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">FNF Report</span></a></li>
                                @endcanany

                                {{--It get HR--}}
                                @canany([
                                _permission(\App\Utils\Permissions::HR_HOD_VIEW),
                                _permission(\App\Utils\Permissions::IT_HOD_VIEW)
                                ])
                                <li class="kt-menu__item {{ ($active == 'user-request-to-hr') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{ route('user.request.clearance.hr') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">User Closing Approval(HR)</span></a></li>
                                <li class="kt-menu__item {{ ($active == 'user-final-closing-request-to-hr') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{ route('user.final.closing.request.clearance.hr') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">User Final Closing(HR)</span></a></li>
                                @endcanany






                            </ul>
                        </div>
                    </li>
                    {{-- user loan panel end --}}

                    {{-- user appraisal --}}

                    <li style="display: none" class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['user-my-team-appraisal', 'user-appraisal-hr', 'user-my-team-evaluation', 'user-team-evaluation', 'user-team-appraisal', 'user-team-member-evaluation', 'team-lead-evaluation', 'own-leading-evaluation', 'user-my-team-appraisal-dashboard', 'own-leading-evaluation-dashboard', 'user-my-evaluation-dashboard']) ? 'kt-menu__item--open' : ''}}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                    <i class="kt-menu__link-icon flaticon-settings"></i>
                    </span><span class="kt-menu__link-text">Performance Review</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['user-my-team-evaluation', 'user-my-team-appraisal', 'user-my-team-appraisal-dashboard', 'user-my-evaluation-dashboard']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                </span><span class="kt-menu__link-text">My E/A</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                        <ul class="kt-menu__subnav">
                                            <li class="kt-menu__item {{ ($active == 'user-my-team-evaluation')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('user.my.evaluation.list') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">My Evaluation</span></a></li>
                                            <li class="kt-menu__item {{ (in_array($active, ['user-my-team-appraisal', 'user-team-member-evaluation']))? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('user.my.appraisal.list') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">My Appraisal</span></a></li>
                                            <li class="kt-menu__item {{ ($active == 'user-my-evaluation-dashboard')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('user.my.evaluation.dashboard') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-presentation"><span></span></i><span class="kt-menu__link-text">Evaluation Summary</span></a></li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['team-lead-evaluation']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                </span><span class="kt-menu__link-text">Team Lead Evaluation</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                        <ul class="kt-menu__subnav">
                                            <li class="kt-menu__item {{ ($active == 'team-lead-evaluation')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('evaluation.list.for.lead.by.user') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Evaluation</span></a></li>
                                        </ul>
                                    </div>
                                </li>

                                @canany([_permission(\App\Utils\Permissions::TEAM_VIEW), _permission(\App\Utils\Permissions::SUPERVISOR_VIEW)])  {{--It get team lead--}}
                                <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['user-team-evaluation', 'user-team-appraisal']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                </span><span class="kt-menu__link-text">Team Member</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                        <ul class="kt-menu__subnav">
                                            <li class="kt-menu__item {{ ($active == 'user-team-evaluation')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('user.lead.evaluation.list') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-calendar-2"></i><span class="kt-menu__link-text">Member Evaluation</span></a></li>
                                            <li class="kt-menu__item {{ ($active == 'user-team-appraisal')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('user.lead.appraisal.list') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-calendar-2"></i><span class="kt-menu__link-text">Member Appraisal</span></a></li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--here {{ in_array($active, ['own-leading-evaluation', 'own-leading-evaluation-dashboard']) ? 'kt-menu__item--open' : '' }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-icon">
                                <i class="kt-menu__link-icon flaticon-calendar-2"></i>
                                </span><span class="kt-menu__link-text">Own Leading Evaluation</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                    <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                        <ul class="kt-menu__subnav">
                                            <li class="kt-menu__item {{ ($active == 'own-leading-evaluation')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('own.leading.evaluation.list') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Evaluation</span></a></li>
                                            <li class="kt-menu__item {{ ($active == 'own-leading-evaluation-dashboard')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('own.leading.evaluation.dashboard') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-presentation"><span></span></i><span class="kt-menu__link-text">Evaluation Summary</span></a></li>
                                        </ul>
                                    </div>
                                </li>
                                @endcanany

                                {{--It is used from Closing setting--}}
                                @if(auth()->user()->employee_id === $userListArr['hr_hod_id']) {{--It get HR--}}
                                <li class="kt-menu__item {{ ($active == 'user-appraisal-hr') ? 'kt-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{ route('user.hr.appraisal.list') }}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">User Appraisal Approval(HR)</span></a></li>
                                @endif

                            </ul>
                        </div>
                    </li>
                    {{-- user appraisal --}}

                    <!-- Upcomming -->
                    <li class="kt-menu__item {{ ($active == 'upcomming-events')? 'kt-menu__item--active' : '' }} " aria-haspopup="true"><a href="{{ route('upcomming.index') }}" class="kt-menu__link "><i class="kt-menu__link-icon flaticon-calendar-2"></i><span class="kt-menu__link-text">Upcomming</span></a></li>

                @endif






            </ul>
        </div>
    </div>

    <!-- end:: Aside Menu -->
</div>

<!-- end:: Aside -->
