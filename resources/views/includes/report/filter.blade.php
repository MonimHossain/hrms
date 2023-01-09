<div class="kt-portlet kt-portlet--collapsed" data-ktportlet="true" id="kt_portlet_tools_1">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon-interface-7"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    Filter
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-group">
                    <a href="#" data-ktportlet-tool="toggle" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i class="la la-angle-down"></i></a>
                    <a href="#" id="reload" data-ktportlet-tool="reload" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i class="la la-refresh"></i></a>
                    <a href="{{ route('general.report') }}" id="reset" data-ktportlet-tool="reload" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i class="la la-trash-o"></i></a>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-portlet__content {{ $is_stat ? 'hidden':'' }}" id="data_form">
                <div class="">
                    <div class="kt-portlet__body">
                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ isset($filters['report_type']) ? $filters['report_type'] == 'employeeInfo' ? 'active': '' : 'active' }}" data-toggle="tab" href="#" data-target="#kt_tabs_1_1">Employee Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ isset($filters['report_type']) && $filters['report_type'] == 'attendanceReport' ? 'active': '' }}" data-toggle="tab" href="#kt_tabs_1_2">Attendance</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ isset($filters['report_type']) && $filters['report_type'] == 'leaveReport' ? 'active':'' }}" data-toggle="tab" href="#kt_tabs_1_3">Leave</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tabs_1_4">Salary</a>
                            </li> -->
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane   {{ isset($filters['report_type']) ? $filters['report_type'] == 'employeeInfo' ? 'active': '' : 'active' }}" id="kt_tabs_1_1" role="tabpanel">

                                <form action="{{ url('report') }}" method="GET" class="kt-form center-division-form">
                                    <input type="hidden" name="report_type" value="employeeInfo">
                                    <!--  -->
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Date range filter</label>
                                                <select name="filter_type" id="dateRangeFilter" class="form-control">
                                                    <option value="all" {{ isset($filters['filter_type']) && $filters['filter_type'] == 'all' ? 'selected':'' }}>All</option>
                                                    <option value="new_join" {{ isset($filters['filter_type']) && $filters['filter_type'] == 'new_join' ? 'selected':'' }}>New Join</option>
                                                    <option value="provision_expiring" {{ isset($filters['filter_type']) && $filters['filter_type'] == 'provision_expiring' ? 'selected':'' }}>Provition Expiring</option>
                                                    <option value="contract_expiring" {{ isset($filters['filter_type']) && $filters['filter_type'] == 'contract_expiring' ? 'selected':'' }}>Contract Expiring</option>
                                                    {{-- <option value="birthday" {{ isset($filters['filter_type']) && $filters['filter_type'] == 'birthday' ? 'selected':'' }}>Birthday</option> --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 datePicker">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="date" class="form-control" value="{{ isset($filters['start_date']) ? $filters['start_date']: '' }}" name="start_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3 datePicker">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="date" class="form-control" value="{{ isset($filters['end_date']) ? $filters['end_date']: '' }}" name="end_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Division</label>
                                                <div>
                                                    <select class="form-control kt-select2 division" id="kt_select2_222" name="division" required>
                                                        <option value="">Select Option</option>
                                                        @foreach($divisions as $division)
                                                            <option value="{{ $division->id }}" {{ isset($filters['division']) && $filters['division'] == $division->id ? 'selected': '' }}>{{ $division->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Center</label>
                                                <div>
                                                    <select class="form-control kt-select2 center" id="kt_select2_222" name="center" required>
                                                        <option value="">Select Center</option>
                                                        @if(isset($filters['division']))
                                                            @foreach($centers as $center)
                                                                <option value="{{ $center->id }}" {{ isset($filters['center']) && $filters['center'] == $center->id ? 'selected': '' }}>{{ $center->center }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Department</label>
                                                <div>
                                                    <select class="form-control kt-select2 department" id="kt_select2_22" name="department">
                                                        <option value="">Select Option</option>
                                                        @if(isset($filters['center']))
                                                            @foreach($departments as $department)
                                                                <option value="{{ $department->id }}" {{ isset($filters['department']) && $filters['department'] == $department->id ? 'selected': '' }}>{{ $department->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Process</label>
                                                <div>
                                                    <select class="form-control kt-select2 process" id="kt_select2_31" name="process">
                                                        <option value="">Select Option</option>
                                                        @if(isset($filters['department']))
                                                            @foreach($processes as $process)
                                                                <option value="{{ $process->id }}" {{ isset($filters['process']) && $filters['process'] == $process->id ? 'selected': '' }}>{{ $process->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Process segment</label>
                                                <div>
                                                    <select class="form-control kt-select2 process-segment" id="kt_select2_62" name="process_segment">
                                                        <option value="">Select Option</option>
                                                        @if(isset($filters['process']))
                                                            @foreach($processSegments as $processSegment)
                                                                <option value="{{ $processSegment->id }}" {{ isset($filters['process_segment']) && $filters['process_segment'] == $processSegment->id ? 'selected': '' }}>{{ $processSegment->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Employment Type</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_32" name="employment_type">
                                                        <option value="">Select Option</option>
                                                        @foreach($employmentTypes as $employmentType)
                                                            <option value="{{ $employmentType->id }}" {{ isset($filters['employment_type']) && $filters['employment_type'] == $employmentType->id ? 'selected': '' }}>{{ $employmentType->type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Designation</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_85" name="designation">
                                                        <option value="">Select Option</option>
                                                        @foreach($designations as $designation)
                                                            <option value="{{ $designation->id }}" {{ isset($filters['designation']) && $filters['designation'] == $designation->id ? 'selected': '' }}>{{ $designation->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Employee Status</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_38" name="employee_status">
{{--                                                        <option value="">All</option>--}}
                                                        @foreach($employeeStatuses as $employeeStatus)
{{--                                                            <option value="{{ $employeeStatus->id }}" {{ ((isset($filters['employee_status']) && $filters['employee_status'] == $employeeStatus->id)) ? 'selected': '' }}>{{ $employeeStatus->status }}</option>--}}
                                                            <option value="{{ $employeeStatus->id }}" {{ ((isset($filters['employee_status']) && $filters['employee_status'] == $employeeStatus->id) || !isset($filters['employee_status']) && $employeeStatus->id == 1) ? 'selected': '' }}>{{ $employeeStatus->status }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_93" name="gender">
                                                        <option value="">Select Option</option>
                                                        @foreach($genders as $gender)
                                                            <option value="{{ $gender }}" {{ isset($filters['gender']) && $filters['gender'] == $gender ? 'selected': '' }}>{{ $gender }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Blood Group</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_103" name="blood_group">
                                                        <option value="">Select Option</option>
                                                        @foreach($bloodGroups as $bloodGroup)
                                                            <option value="{{ $bloodGroup->id }}"  {{ isset($filters['blood_group']) && $filters['blood_group'] == $bloodGroup->id ? 'selected': '' }}>{{ $bloodGroup->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Religion</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_1000" name="religion">
                                                        <option value="">Select Option</option>
                                                        @foreach($employee_religions as $employee_religion)
                                                            <option value="{{ $employee_religion }}" {{ isset($filters['religion']) && $filters['religion'] == $employee_religion ? 'selected': '' }}>{{ $employee_religion }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Paginate</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_1000" name="pagination">
                                                        <option value="">Select Option</option>
                                                        <option value="10" {{ isset($filters['pagination']) && $filters['pagination'] == 10 ? 'selected': '' }} >10</option>
                                                        <option value="50" {{ isset($filters['pagination']) && $filters['pagination'] == 50 ? 'selected': '' }}>50</option>
                                                        <option value="100" {{ isset($filters['pagination']) && $filters['pagination'] == 100 ? 'selected': '' }}>100</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-last">
                                        <div class="alert alert-secondary" role="alert">
                                            <div class="kt-form__actions margin-right-10">
                                                <button type="submit" class="btn btn-primary" name="is_csv" value="false"><i class="flaticon-cogwheel-1"></i> Generate Report</button>
                                            </div>
                                            <div class="kt-form__actions ">
                                                <button type="submit" class="btn btn-primary" name="is_csv" value="true"><i class="flaticon-cogwheel-1"></i> Generate CSV</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane {{ isset($filters['report_type']) && $filters['report_type'] == 'attendanceReport' ? 'active': '' }}" id="kt_tabs_1_2" role="tabpanel">

                                <form action="{{ url('report') }}" method="GET" class="kt-form">

                                    <input type="hidden" name="report_type" value="attendanceReport">

                                    <div class="row">
                                        <div class="col-xl-2">
                                            <div class="form-group">
                                                <label>Date From</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control"  autocomplete="off" placeholder="Select Month"
                                                        id="month-pick" name="datefrom" required value="{{ isset($filters['datefrom']) ? $filters['datefrom']: '' }}" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2">
                                            <div class="form-group">
                                                <label>Date To</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control"  autocomplete="off" placeholder="Select Year"
                                                        id="year-pick" name="dateto" required value="{{ isset($filters['dateto']) ? $filters['dateto']: '' }}" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2">
                                            <div class="form-group">
                                                <label>Department</label>
                                                <select name="department_id" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach ($departments as $item)
                                                    <option
                                                        {{ (isset($filters['department_id']) && $filters['department_id']== $item->id) ? 'selected' : '' }}
                                                        value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-2">
                                            <div class="form-group">
                                                <label>Process</label>
                                                <select name="process_id" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach ($processes as $item)
                                                    <option
                                                        {{ (isset($filters['process_id']) && $filters['process_id'] == $item->id) ? 'selected' : '' }}
                                                        value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-2">
                                            <div class="form-group">
                                                <label>Shift</label>
                                                <select name="shift" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach ($roster as $item)
                                                    <option
                                                        {{ (isset($filters['shift']) && $filters['shift'] == $item->roster_start) ? 'selected' : '' }}
                                                        value="{{ $item->roster_start }}">{{ $item->roster_start }} - {{ $item->roster_end }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-2">
                                            <div class="form-group">
                                                <label>Display Type</label>
                                                <select name="display_type" class="form-control">
                                                    <option value="Paginate">Paginate</option>
                                                    <option value="All">All</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 hidden">
                                            <div class="form-group">
                                                <label>Employee:</label>
                                                <select id="employee_id" name="employee_id" class="form-control kt-selectpicker " data-live-search="true"
                                                        data-placeholder="Select Employee">
                                                    <option value="" selected="selected">Select</option>
                                                    <select id="kt_select2_1" name="employee_id" class="form-control kt-select2" name="param">
                                                        @foreach ($employees as $employee)
                                                            <option value="{{$employee->id}}" data-tokens="{{ $employee->FullName }}">{{ $employee->employer_id }}
                                                                - {{ $employee->FullName }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <div class="kt-form__actions" >
                                                    <button type="submit" class="btn btn-primary">Filter</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane {{ isset($filters['report_type']) && $filters['report_type'] == 'leaveReport' ? 'active':'' }}" id="kt_tabs_1_3" role="tabpanel">
                                <form action="{{ url('report') }}" method="GET" class="kt-form center-division-form">

                                <input type="hidden" name="report_type" value="leaveReport">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Leave report Type</label>
                                                <div>
                                                    <select class="form-control kt-select2" name="leave_report_type" id="leaveReportType" required>
                                                        <option value="">Select Option</option>
                                                        <option value="Use" {{ isset($filters['leave_report_type']) && $filters['leave_report_type'] == 'Use' ? 'selected': '' }}>Use</option>
                                                        <option value="Balance" {{ isset($filters['leave_report_type']) && $filters['leave_report_type'] == 'Balance' ? 'selected': '' }}>Balance</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 yearRange">
                                            <label>Year</label>
                                            <label>Date From</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control year-pick"
                                                       placeholder="Select Date"
                                                       autocomplete="off"
                                                       name="year" value="{{ Request::get('year') }}"/>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-calendar-check-o"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 dataRange">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="date" autocomplete="off" class="form-control date-pick" value="{{ isset($filters['start_date']) ? $filters['start_date']: '' }}" name="start_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3 dataRange">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="date" autocomplete="off" class="form-control date-pick" value="{{ isset($filters['end_date']) ? $filters['end_date']: '' }}" name="end_date">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Division</label>
                                                <div>
                                                    <select class="form-control kt-select2 division" id="kt_select2_222" name="division">
                                                        <option value="">Select Option</option>
                                                        @foreach($divisions as $division)
                                                            <option value="{{ $division->id }}" {{ isset($filters['division']) && $filters['division'] == $division->id ? 'selected': '' }}>{{ $division->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Center</label>
                                                <div>
                                                    <select class="form-control kt-select2 center" id="kt_select2_222" name="center">
                                                        <option value="">Select Center</option>
                                                        @if(isset($filters['division']))
                                                            @foreach($centers as $center)
                                                                <option value="{{ $center->id }}" {{ isset($filters['center']) && $filters['center'] == $center->id ? 'selected': '' }}>{{ $center->center }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Department</label>
                                                <div>
                                                    <select class="form-control kt-select2 department" id="kt_select2_22" name="department">
                                                        <option value="">Select Option</option>
                                                        @if(isset($filters['center']))
                                                            @foreach($departments as $department)
                                                                <option value="{{ $department->id }}" {{ isset($filters['department']) && $filters['department'] == $department->id ? 'selected': '' }}>{{ $department->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Process</label>
                                                <div>
                                                    <select class="form-control kt-select2 process" id="kt_select2_31" name="process">
                                                        <option value="">Select Option</option>
                                                        @if(isset($filters['department']))
                                                            @foreach($processes as $process)
                                                                <option value="{{ $process->id }}" {{ isset($filters['process']) && $filters['process'] == $process->id ? 'selected': '' }}>{{ $process->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Process segment</label>
                                                <div>
                                                    <select class="form-control kt-select2 process-segment" id="kt_select2_62" name="process_segment">
                                                        <option value="">Select Option</option>
                                                        @if(isset($filters['process']))
                                                            @foreach($processSegments as $processSegment)
                                                                <option value="{{ $processSegment->id }}" {{ isset($filters['process_segment']) && $filters['process_segment'] == $processSegment->id ? 'selected': '' }}>{{ $processSegment->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Designation</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_85" name="designation">
                                                        <option value="">Select Option</option>
                                                        @foreach($designations as $designation)
                                                            <option value="{{ $designation->id }}" {{ isset($filters['designation']) && $filters['designation'] == $designation->id ? 'selected': '' }}>{{ $designation->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_93" name="gender">
                                                        <option value="">Select Option</option>
                                                        @foreach($genders as $gender)
                                                            <option value="{{ $gender }}" {{ isset($filters['gender']) && $filters['gender'] == $gender ? 'selected': '' }}>{{ $gender }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Leave Type</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_103" name="leave_type">
                                                        <option value="">Select Option</option>
                                                        @foreach($leaveTypes as $leaveType)
                                                            <option {{ isset($filters['leave_type']) && $filters['leave_type'] == $leaveType->id ? 'selected': '' }} value="{{ $leaveType->id }}">{{ $leaveType->leave_type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Employee Status</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_38" name="employee_status">
                                                        <option value="">Select Option</option>
                                                        @foreach($employeeStatuses as $employeeStatus)
                                                            <option value="{{ $employeeStatus->id }}" {{ isset($filters['employee_status']) && $filters['employee_status'] == $employeeStatus->id ? 'selected': '' }}>{{ $employeeStatus->status }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Employment type</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_38" name="employment_type">
                                                        <option value="">Select Option</option>
                                                        @foreach($employmentTypes as $employmentType)
                                                            <option value="{{ $employmentType->id }}" {{ isset($filters['employment_type']) && $filters['employment_type'] == $employmentType->id ? 'selected': '' }}>{{ $employmentType->type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Halfday</label>
                                                <div class="form-check">
                                                    <input type="checkbox" {{ isset($filters['is_halfday']) ? 'checked': '' }} class="form-check-input" name="is_halfday" id="exampleCheck1">
                                                    <label class="form-check-label" for="exampleCheck1">Halfday leaves</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="team_lead_id">Employee</label>
                                                <select class="form-control kt-selectpicker " data-live-search="true" id="employee_id2"
                                                        name="employee_id">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-last">
                                        <div class="alert alert-secondary" role="alert">
                                            {{-- <div class="kt-form__actions">
                                                <button name="submit" value="search" type="submit" class="btn btn-primary"><i class="flaticon-cogwheel-1"></i> Generate</button>
                                            </div> --}}
                                            <div class="kt-form__actions margin-right-10">
                                                <button type="submit" class="btn btn-primary" name="is_csv" value="false"><i class="flaticon-cogwheel-1"></i> Generate Report</button>
                                            </div>
                                            <div class="kt-form__actions ">
                                                <button type="submit" class="btn btn-primary" name="is_csv" value="true"><i class="flaticon-cogwheel-1"></i> Generate CSV</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="kt-portlet__content {{ $is_stat ? '':'hidden' }}" id="stat_form">
                <div class="kt-portlet">
                    <div class="kt-portlet__body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#" data-target="#kt_tabs_2_1">Employee head count</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tabs_2_2">Attendance</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_tabs_2_3">Salary Analysis</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="kt_tabs_2_1" role="tabpanel">
                                <form action="{{ url('report') }}" method="GET" class="kt-form">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="date" class="form-control" required value="{{ isset($filters['start_date']) ? $filters['start_date']: '' }}" name="start_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="date" class="form-control" required value="{{ isset($filters['end_date']) ? $filters['end_date']: '' }}" name="end_date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-last">
                                        <div class="alert alert-secondary" role="alert">
                                            <div class="kt-form__actions">
                                                <button name="submit" value="headcountStat" type="submit" class="btn btn-primary"><i class="flaticon-cogwheel-1"></i> Generate</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="kt_tabs_2_2" role="tabpanel">
                                <form action="{{ url('report') }}" method="GET" class="kt-form">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="date" class="form-control" value="{{ isset($filters['start_date']) ? $filters['start_date']: '' }}" name="start_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="date" class="form-control" value="{{ isset($filters['start_date']) ? $filters['start_date']: '' }}" name="end_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Department</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_13" name="process">
                                                        <option value="">Select report</option>
                                                        <option value="">Department wise</option>
                                                        <option value="">Process wise</option>
                                                        <option value="">Employment type</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Process</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_13" name="process">
                                                        <option value="">Select report</option>
                                                        <option value="">Department wise</option>
                                                        <option value="">Process wise</option>
                                                        <option value="">Employment type</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Segment</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_13" name="process">
                                                        <option value="">Select report</option>
                                                        <option value="">Department wise</option>
                                                        <option value="">Process wise</option>
                                                        <option value="">Employment type</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-last">
                                        <div class="alert alert-secondary" role="alert">
                                            <div class="kt-form__actions">
                                                <button name="submit" value="search" type="submit" class="btn btn-primary"><i class="flaticon-cogwheel-1"></i> Generate</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="kt_tabs_2_3" role="tabpanel">
                                <form action="{{ url('report') }}" method="GET" class="kt-form">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="date" class="form-control" value="{{ isset($filters['start_date']) ? $filters['start_date']: '' }}" name="start_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="date" class="form-control" value="{{ isset($filters['start_date']) ? $filters['start_date']: '' }}" name="end_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Minimum Salary</label>
                                                <input type="text" class="form-control" value="{{ isset($filters['start_date']) ? $filters['start_date']: '' }}" name="start_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Maximum Salary</label>
                                                <input type="text" class="form-control" value="{{ isset($filters['start_date']) ? $filters['start_date']: '' }}" name="end_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Department</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_13" name="process">
                                                        <option value="">Select report</option>
                                                        <option value="">Department wise</option>
                                                        <option value="">Process wise</option>
                                                        <option value="">Employment type</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Process</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_13" name="process">
                                                        <option value="">Select report</option>
                                                        <option value="">Department wise</option>
                                                        <option value="">Process wise</option>
                                                        <option value="">Employment type</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Segment</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_13" name="process">
                                                        <option value="">Select report</option>
                                                        <option value="">Department wise</option>
                                                        <option value="">Process wise</option>
                                                        <option value="">Employment type</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-last">
                                        <div class="alert alert-secondary" role="alert">
                                            <div class="kt-form__actions">
                                                <button name="submit" value="search" type="submit" class="btn btn-primary"><i class="flaticon-cogwheel-1"></i> Generate</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="kt_tabs_2_4" role="tabpanel">
                                <form action="{{ url('report') }}" method="GET" class="kt-form">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="date" class="form-control" value="{{ isset($filters['start_date']) ? $filters['start_date']: '' }}" name="start_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="date" class="form-control" value="{{ isset($filters['start_date']) ? $filters['start_date']: '' }}" name="end_date">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Department</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_13" name="process">
                                                        <option value="">Select report</option>
                                                        <option value="">Department wise</option>
                                                        <option value="">Process wise</option>
                                                        <option value="">Employment type</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Process</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_13" name="process">
                                                        <option value="">Select report</option>
                                                        <option value="">Department wise</option>
                                                        <option value="">Process wise</option>
                                                        <option value="">Employment type</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Segment</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_13" name="process">
                                                        <option value="">Select report</option>
                                                        <option value="">Department wise</option>
                                                        <option value="">Process wise</option>
                                                        <option value="">Employment type</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Report Type</label>
                                                <div>
                                                    <select class="form-control kt-select2" id="kt_select2_13" name="process">
                                                        <option value="">Select report</option>
                                                        <option value="">Department wise</option>
                                                        <option value="">Process wise</option>
                                                        <option value="">Employment type</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-last">
                                        <div class="alert alert-secondary" role="alert">
                                            <div class="kt-form__actions">
                                                <button name="submit" value="search" type="submit" class="btn btn-primary"><i class="flaticon-cogwheel-1"></i> Generate</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->

            </div>

        </div>
    </div>
{{--{{dd(request()->get('employee_id'))}}--}}

    @push('js')
        @include('layouts.partials.includes.division-center')
    @endpush

    @push('library-js')
<script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
</script>
@endpush


@push('js')
<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
</script>

<script>

    function addSelect2Ajax($element, $url, $changeCallback, data) {
        var placeHolder = $($element).data('placeholder');

        if (typeof $changeCallback == 'function') {
            $($element).change($changeCallback)
        }

        // $($element).hasClass('select2') && $($element).select2('destroy');

        return $($element).select2({
            allowClear: true,
            width: "resolve",
            ...data,
            placeholder: placeHolder,
            ajax: {
                url: $url,
                data: function (params) {
                    return {
                        keyword: params.term,
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (obj, index) {
                            return {id: obj.id, text: obj.name};
                        })
                    };
                }
            }
        });

    }

    addSelect2Ajax('#employee_id', "{{route('employee.all')}}");


</script>

<script>

    function addSelect2Ajax($element, $url, $changeCallback, data) {
        var placeHolder = $($element).data('placeholder');

        if (typeof $changeCallback == 'function') {
            $($element).change($changeCallback)
        }

        // $($element).hasClass('select2') && $($element).select2('destroy');

        return $($element).select2({
            allowClear: false,
            width: "resolve",
            ...data,
            placeholder: placeHolder,
            ajax: {
                url: $url,
                data: function (params) {
                    return {
                        keyword: params.term,
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (obj, index) {
                            return {id: obj.id, text: obj.name};
                        })
                    };
                },
                cache: true
            }
        });

    }

    addSelect2Ajax('#employee_id2', "{{route('employee.all')}}");



</script>

<script>
    var arrows;
if (KTUtil.isRTL()) {
    arrows = {
        leftArrow: '<i class="la la-angle-right"></i>',
        rightArrow: '<i class="la la-angle-left"></i>'
    }
} else {
    arrows = {
        leftArrow: '<i class="la la-angle-left"></i>',
        rightArrow: '<i class="la la-angle-right"></i>'
    }
}

$('#month-pick').datepicker({
    rtl: KTUtil.isRTL(),
    todayBtn: "linked",
    clearBtn: true,
    todayHighlight: true,
    orientation: "bottom left",
    templates: arrows,
    format: 'yyyy-mm-dd',
    // viewMode: 'months',
    // minViewMode: 'months'
});

$('#year-pick').datepicker({
    rtl: KTUtil.isRTL(),
    todayBtn: "linked",
    clearBtn: true,
    todayHighlight: true,
    orientation: "bottom left",
    templates: arrows,
    format: 'yyyy-mm-dd',
    // viewMode: "years",
    // minViewMode: "years"
});
</script>

<script>
    $('#attendance_info').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var attendance_id = button.data('attendance-id') // Extract info from data-* attributes
    let url = "{{ route('employee.attandance.details') }}";
    $.ajax({
        type: "post",
        url: url,
        data: {
            attendance_id,
            "_token": "{{ csrf_token() }}",
        },
        // dataType: 'json',
        success: function(res) {
            $('.modal-body').html(res);

        },
        error:function(request, status, error) {
            console.log("ajax call went wrong:" + request.responseText);
        }
    });
});
</script>
@endpush

