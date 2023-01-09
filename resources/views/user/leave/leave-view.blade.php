<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
    <div class="row">
        <div class="col-md-12">
            <!--begin::Portlet-->
            <!--begin::Form-->
{{--            {{dd(request('approval_type'))}}--}}
            @if($type == 'hr')
                <form action="{{ route('admin.leave.approval') }}" method="POST">
            @else
                <form action="{{ route('leave.approval') }}" method="POST">
            @endif
                @csrf
                <input type="hidden" value="{{ $leave->id }}" name="leave_id">
                <input type="hidden" value="{{ $approval_type }}" name="approval_type">
                <input type="hidden" value="{{ $approval_id }}" name="approval_id">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12"><label class="bold">Application Date</label> {{ date_format(date_create($leave->created_at), "d/m/Y") }}</div>
                        </div>
                    </div>

                    {{-- <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12"><label class="bold">Subject: </label> {{ $leave->subject }}</div>
                        </div>
                    </div> --}}

                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <label class="bold">Dear Concern,</label><br/>
                                I am {{ $leave->employee->FullName }}, bearing ID <span class="bold">{{ $leave->employee->employer_id }}</span>. I need a leave From <span
                                    class="bold">{{ date_format(date_create($leave->start_date), "d/m/Y") }}</span> To
                                <span class="bold">{{ date_format(date_create($leave->end_date), "d/m/Y") }}</span>, Due to <span class="bold">{{ $leave->description }}</span>,
                                <br>
                                {{-- <br>
                                I will be staying at {{ $leave->leave_location }} during this time period and my duty will resume from <span
                                    class="bold">{{ date_format(date_create($leave->resume_date), "d/m/Y") }}</span>

                                <br> --}}
                                Thanks for consideration in providing me with this opportunity for <span class="bold">{{ _lang('leave.leaveType', $leave->leave_type_id) }}</span>.
                                <br>
                                <br>
                                <span class="bold">Best Regards,</span><br>
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
                                        <label class="bold">{{ (request('approval_type') == 'cancel_leave') ? 'Cancellation' : 'Reject'}} Remarks</label>
                                        <textarea name="remarks" class="form-control" id="" cols="50" rows="3" placeholder="Place a remark for reject reason."></textarea>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif


                </div>
                @if($leave->leave_status ==  \App\Utils\LeaveStatus::PENDING)
                    <br/>
                    @if(request('approval_type'))
                        <div class="col-lg-12">
                            <div class="row">
                                @if(request('approval_type') == 'cancel_leave')
                                    <input type="submit" name="submit" class="btn btn-primary" value="Cancel Leave"/> &nbsp;
                                @else
                                    <input type="submit" name="submit" class="btn btn-primary" value="Approved"/> &nbsp;
                                    <input type="submit" name="submit" class="btn btn-danger" value="Reject">
                                @endif
                            </div>
                        </div>
                    @endif
                @endif


            </form>
            <!--end::Form-->
            <br>
            <br>
            <div class="kt-section dtHorizontalExampleWrapper ">
                <table class="inner-table" id="html_table" width="100%;">
                    <thead>
                        <tr>
                            @if($balances)
                            <tr>
                                @foreach($balances as $balance)
                                    @if(
                                        $balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL ||
                                        $balance->leave_type_id == \App\Utils\LeaveStatus::SICK ||
                                        $balance->leave_type_id == \App\Utils\LeaveStatus::LWP ||
                                        $balance->leave_type_id == \App\Utils\LeaveStatus::EARNED
                                    )
                                    <th  class="bold" colspan="{{ ($balance->leave_type_id == \App\Utils\LeaveStatus::EARNED) ? '3' : '3' }}">{{( $balance->leave_type_id == \App\Utils\LeaveStatus::LWP) ? 'LWP' : _lang('leave.leaveType',$balance->leave_type_id)  }}</th>
                                    @endif
                                @endforeach
                            </tr>
                        @else
                            <div class="alert alert-primary" role="alert">
                                Leave balance not generated yet.
                            </div>
                        @endif
                        </tr>
                        </thead>
                    <tbody>

                    <tr>
                        @if($balances)
                            @php
                                $earnLeaveService = new \App\Services\EarnLeaveService($leave->employee);
                                $employee = $leave->employee;
                                // dd($earnLeaveService);
                            @endphp
                            @foreach($balances as $balance)

                                @if ($employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                    @if($balance->leave_type_id == App\Utils\LeaveStatus::CASUAL)
                                        <td><span class="bold">Total :</span> {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}</td>
                                        <td><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                        <td><span class="bold">Remain :</span> {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeaveRemain()) }}</td>
                                    @endif
                                    @if($balance->leave_type_id == App\Utils\LeaveStatus::SICK)
                                        <td><span class="bold">Total :</span> {{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}</td>
                                        <td><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                        <td><span class="bold">Remain :</span> {{ str_replace('.0', '', $earnLeaveService->proratedSickLeaveRemain()) }}</td>
                                    @endif
                                    @if($balance->leave_type_id == App\Utils\LeaveStatus::EARNED)
                                        <td><span class="bold">Total :</span> {{ str_replace('.0', '', $balance->total) }}</td>
                                        <td><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                        <td><span class="bold">Remain :</span> {{ str_replace('.0', '', $balance->remain) }}</td>
                                    @endif
                                    @if($balance->leave_type_id == App\Utils\LeaveStatus::LWP)
                                        <td colspan="3">
                                            <span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                    @endif
                                @else
                                    <?php
                                        $earnLeaveService = new \App\Services\EarnLeaveService($leave->employee);
                                    ?>
                                    @if($balance->leave_type_id == App\Utils\LeaveStatus::CASUAL)
                                        <td><span class="bold">Total :</span> 
                                            @if($balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}
                                            @elseif($balance->leave_type_id == \App\Utils\LeaveStatus::SICK  && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                {{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}
                                            @else
                                                {{ str_replace('.0', '', $balance->total)  }}
                                            @endif
                                        </td>
                                        <td><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                        <td><span class="bold">Remain :</span> 
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
                                        <td><span class="bold">Total :</span> 
                                            @if($balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}
                                            @elseif($balance->leave_type_id == \App\Utils\LeaveStatus::SICK  && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                {{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}
                                            @else
                                                {{ str_replace('.0', '', $balance->total)  }}
                                            @endif
                                        </td>
                                        <td><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                        <td><span class="bold">Remain :</span> 
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
                                            <td><span class="bold">Total :</span> 
                                                @if($balance->leave_type_id == \App\Utils\LeaveStatus::CASUAL && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                    {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}
                                                @elseif($balance->leave_type_id == \App\Utils\LeaveStatus::SICK  && $employee->employeeJourney->employment_type_id == \App\Utils\EmploymentTypeStatus::PROBATION)
                                                    {{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}
                                                @else
                                                    {{ str_replace('.0', '', ($balance->total + $earnLeaveService->calculateEarnLeaveBalance()) )  }}
                                                @endif
                                            </td>
                                            <td><span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}</td>
                                            <td><span class="bold">Remain :</span> 
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
                                        <td colspan="3">
                                            <span class="bold">Used :</span> {{ str_replace('.0', '', $balance->used) }}
                                        </td>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </tr>
                    </tbody>
                </table>
                <br>
            </div>
           <a class="pull-right" href="{{ route('user.leave.download', ['id' => $id]) }}">Download as PDF</a>
            <!--end::Portlet-->
        </div>
  </div>
</div>




