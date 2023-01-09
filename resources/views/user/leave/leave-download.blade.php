<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>{{ $title }}</title>
</head>
<body>
  <div>

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-12"><label style="font-weight:600;">Application Date</label> {{ date_format(date_create($leave->created_at), "d/m/Y") }}</div>
                </div>
            </div>

            {{-- <div class="col-lg-12">
                <div class="row">
                    <div class="col-12"><label style="font-weight:600;">Subject: </label> {{ $leave->subject }}</div>
                </div>
            </div> --}}

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <label style="font-weight:600;">Dear Concern,</label><br/>
                        I am {{ $leave->employee->FullName }}, bearing ID <span style="font-weight:600;">{{ $leave->employee->employer_id }}</span>. I need a leave From <span
                            style="font-weight:600;">{{ date_format(date_create($leave->start_date), "d/m/Y") }}</span> To
                        <span style="font-weight:600;">{{ date_format(date_create($leave->end_date), "d/m/Y") }}</span>, Due to <span style="font-weight:600;">{{ $leave->description }}</span>,
                        <br>
                        <br>
                        {{-- I will be staying at {{ $leave->leave_location }} during this time period and my duty will resume from <span
                            style="font-weight:600;">{{ date_format(date_create($leave->resume_date), "d/m/Y") }}</span>

                        <br> --}}
                        Thanks for consideration in providing me with this opportunity for <span style="font-weight:600;">{{ _lang('leave.leaveType', $leave->leave_type_id) }}</span>.
                        <br>
                        <br>
                        <span style="font-weight:600;">Best Regards,</span><br>
                        Name : {{ $leave->employee->FullName }} <br>
                        ID : {{ $leave->employee->employer_id }} <br>
                        Team : {{ $leave->employee->teamMember()->wherePivot('member_type', \App\Utils\TeamMemberType::MEMBER)->first()->name ?? '' }} <br>
                        @if($leave->leaveDocuments->count()) Leave Document : <a target="_blank"
                                                                                    href="{{ \Storage::url('public/employee/leave_documents/'.$leave->leaveDocuments->first()->file_name) }}"><i
                                class="fa fa-file"></i> Document </a>@endif
                    </div>
                </div>
            </div>
            @if($leave->leave_status ==  \App\Utils\LeaveStatus::PENDING)
                @if(request('approval_type'))
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <label style="font-weight:600;">{{ (request('approval_type') == 'cancel_leave') ? 'Cancellation' : 'Reject'}} Remarks</label>
                                <textarea name="remarks" class="form-control" id="" cols="50" rows="3" placeholder="Place a remark for reject reason."></textarea>
                            </div>
                        </div>
                    </div>
                @endif
            @endif


        </div>
        <p class="bold">Duration: {{ $leave->quantity }} Days ({{ _lang('leave.leaveType', $leave->leave_type_id) }})</p><br>
        <span>Current Balance: </span>
        <table class="table" style="width: 100%; border-collapse: collapse; margin-top:30px" border="0">
            <thead>
            <tr>
                @if($balances->count() > 0)
                    @foreach($balances as $balance)
                        @if(
                            $balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL ||
                            $balance->leave_type_id == \App\Utils\LeaveStatus::SICK ||
                            $balance->leave_type_id == \App\Utils\LeaveStatus::LWP ||
                            $balance->leave_type_id == \App\Utils\LeaveStatus::EARNED
                        )
                        <th style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;" class="bold" colspan="{{ ($balance->leave_type_id == \App\Utils\LeaveStatus::EARNED) ? '3' : '3' }}">{{( $balance->leave_type_id == \App\Utils\LeaveStatus::LWP) ? 'LWP' : _lang('leave.leaveType',$balance->leave_type_id)  }}</th>
                        @endif
                    @endforeach
                @else
                    <th>Please Generate Leave Balance First</th>
                @endif
            </tr>
            </thead>
            <tbody>

            <tr>
                @if($balances->count() > 0)
                    @php
                      $earnLeaveService = new App\Services\EarnLeaveService($leave->employee);
                      $employee = $leave->employee;
                    @endphp
                    @foreach($balances as $balance)
                        @if (auth()->user()->employeeDetails->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                            @if($balance->leave_type_id == App\Utils\LeaveStatus::CASUAL)
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Total :</span> {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}</td>
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Remain :</span> {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeaveRemain()) }}</td>
                            @endif
                            @if($balance->leave_type_id == App\Utils\LeaveStatus::SICK)
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Total :</span> {{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}</td>
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Remain :</span> {{ str_replace('.0', '', $earnLeaveService->proratedSickLeaveRemain()) }}</td>
                            @endif
                            @if($balance->leave_type_id == App\Utils\LeaveStatus::EARNED)
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Total :</span> {{ str_replace('.0', '', $balance->total) }}</td>
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Remain :</span> {{ str_replace('.0', '', $balance->remain) }}</td>
                            @endif
                            @if($balance->leave_type_id == App\Utils\LeaveStatus::LWP)
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;" colspan="3">
                                    <span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                            @endif
                        @else
                            <?php
                                $earnLeaveService = new \App\Services\EarnLeaveService($leave->employee);
                                $employee = $leave->employee;
                            ?>
                            @if($balance->leave_type_id == App\Utils\LeaveStatus::CASUAL)
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Total :</span> 
                                    @if($balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                        {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}
                                    @elseif($balance->leave_type_id == \App\Utils\LeaveStatus::SICK  && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                        {{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}
                                    @else
                                        {{ str_replace('.0', '', $balance->total)  }}
                                    @endif
                                </td>
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Remain :</span> 
                                    @if($balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                        {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeaveRemain()) }}
                                    @elseif($balance->leave_type_id == \App\Utils\LeaveStatus::SICK && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                        {{ str_replace('.0', '', $earnLeaveService->proratedSickLeaveRemain()) }}
                                    @else
                                        {{ str_replace('.0', '', $balance->remain)  }}
                                    @endif
                                </td>
                            @endif
                            @if($balance->leave_type_id == App\Utils\LeaveStatus::SICK)
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Total :</span> 
                                    @if($balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                        {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}
                                    @elseif($balance->leave_type_id == \App\Utils\LeaveStatus::SICK  && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                        {{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}
                                    @else
                                        {{ str_replace('.0', '', $balance->total)  }}
                                    @endif
                                </td>
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Remain :</span> 
                                    @if($balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                        {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeaveRemain()) }}
                                    @elseif($balance->leave_type_id == \App\Utils\LeaveStatus::SICK && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                        {{ str_replace('.0', '', $earnLeaveService->proratedSickLeaveRemain()) }}
                                    @else
                                        {{ str_replace('.0', '', $balance->remain)  }}
                                    @endif
                                </td>
                            @endif
                            @if($balance->leave_type_id == App\Utils\LeaveStatus::EARNED)
                                    <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Total :</span> 
                                        @if($balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                            {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}
                                        @elseif($balance->leave_type_id == \App\Utils\LeaveStatus::SICK  && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                            {{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}
                                        @else
                                            {{ str_replace('.0', '', ($balance->total + $earnLeaveService->calculateEarnLeaveBalance()) )  }}
                                        @endif
                                    </td>
                                    <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                    <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;"><span class="bold">Remain :</span> 
                                        @if($balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                            {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeaveRemain()) }}
                                        @elseif($balance->leave_type_id == \App\Utils\LeaveStatus::SICK && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                            {{ str_replace('.0', '', $earnLeaveService->proratedSickLeaveRemain()) }}
                                        @else
                                            {{ str_replace('.0', '', ($balance->total + $earnLeaveService->calculateEarnLeaveBalance() - $balance->used))  }}
                                        @endif
                                    </td>
                            @endif
                            @if($balance->leave_type_id == App\Utils\LeaveStatus::LWP)
                                <td style="text-align:left; padding: 5px;border: 1px solid black;border-collapse: collapse;" colspan="3">
                                    <span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}
                                </td>
                            @endif
                        @endif
                    @endforeach
                @endif
            </tr>
            </tbody>
        </table>

        <div class="col-md-12">
            <p class="text-center">
                Note: This is system generated payslip does not required seal and signature
            </p>
        </div>
  </div>
</body>
</body>
</html>
