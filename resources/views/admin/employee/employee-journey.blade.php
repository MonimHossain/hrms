@extends('layouts.container')

@section('content')



<div class="kt-content  kt-grid__item   id" id="kt_content">
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Employee Journey
                </h3>
            </div>
        </div>
        {{-- <div class="container">
            <h4>Timeline Style : Demo-2</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="main-timeline2">
                        <div class="timeline">
                            <span class="icon fa fa-globe"></span>
                            <a href="#" class="timeline-content">
                                <h3 class="title">Web Designer</h3>
                                <p class="description">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer malesuada tellus lorem, et condimentum neque commodo quis.
                                </p>
                            </a>
                        </div>
                        <div class="timeline">
                            <span class="icon fa fa-rocket"></span>
                            <a href="#" class="timeline-content">
                                <h3 class="title">Web Developer</h3>
                                <p class="description">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer malesuada tellus lorem, et condimentum neque commodo quis.
                                </p>
                            </a>
                        </div>
                        <div class="timeline">
                            <span class="icon fa fa-briefcase"></span>
                            <a href="#" class="timeline-content">
                                <h3 class="title">Web Designer</h3>
                                <p class="description">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer malesuada tellus lorem, et condimentum neque commodo quis.
                                </p>
                            </a>
                        </div>
                        <div class="timeline">
                            <span class="icon fa fa-mobile"></span>
                            <a href="#" class="timeline-content">
                                <h3 class="title">Web Developer</h3>
                                <p class="description">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer malesuada tellus lorem, et condimentum neque commodo quis.
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-2x nav-tabs-line-success" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_tabs_6_1" role="tab">Employment Journey</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tabs_6_2" role="tab">Team Journey</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="kt_tabs_6_1" role="tabpanel">
                            <div class="main-timeline2">
                                @foreach ($journeys as $item)
                                <div class="timeline">
                                    <span class="icon fa fa-rocket"></span>
                                    <a href="#" class="timeline-content">
                                        <h3 class="title">History <span class="float-right" style="font-size: 12px; margin-top: 10px;">{{ $item->created_at }}</span></h3>
                                        <div class="row mt-4">

                                            @if (!is_null($item->employer_id))
                                                <!-- /.col-lg-6 -->
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-5"><label class="bold">Employee ID:</label></div>
                                                            <!-- /.col-5 -->
                                                            <div class="col-7">{{ $item->employer_id }}</div>
                                                            <!-- /.col-7 -->
                                                        </div>
                                                        <!-- /.row -->
                                                    </div>
                                            @endif

                                            @if (!is_null($item->process_id))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Process:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ optional($item->process)->name}}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->process_segment_id))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Process Segment:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ optional($item->processSegment)->name }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->designation_id))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Designation:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ optional($item->designation)->name }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->job_role_id))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Job Role:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ optional($item->jobRole)->name }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->department_id))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Department:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ optional($item->department)->name }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->employment_type_id))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Employment Type:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->employmentType->type }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->employee_status_id))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Employee Status:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->employeeStatus->status }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->sup1))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Supervisor 1:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ optional($item->supervisor1)->FullName }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->sup2))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Supervisor 2:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ optional($item->supervisor2)->FullName }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->hod))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-6"><label class="bold">Head of Department:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-6">{{ optional($item->headOfDepartment)->FullName }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->doj))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Joining Date:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->doj }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->contract_start_date))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Contract Start:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->contract_start_date }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->contract_end_date))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Contract End:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->contract_end_date }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->process_doj))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Process DOJ:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->Process_doj }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->process_lwd))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Process LWD:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->Process_lwd }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->probation_start_date))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Probation Start:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->probation_start_date }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->probation_period))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Probation Period:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->probation_period }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->probation_remarks))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Probation Remarks:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->probation_remarks }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->permanent_doj))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Permanent DOJ:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->permanent_doj }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->new_role_doj))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">New Role DOJ:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->new_role_doj }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif
                                            <!-- /.col-lg-6 -->
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane" id="kt_tabs_6_2" role="tabpanel">
                                <div class="main-timeline2">
                                    @foreach ($teamJourneys as $item)
                                    <div class="timeline">
                                        <span class="icon fa fa-rocket"></span>
                                        <a href="#" class="timeline-content">
                                            <h3 class="title">Team Journey <span class="float-right" style="font-size: 12px; margin-top: 10px;">{{ $item->added_at }}</span></h3>
                                            <div class="row mt-4">
                                                @if (!is_null($item->department_id))
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Department:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ optional($item->department)->name }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                @endif
                                                <!-- /.col-lg-6 -->
                                                @if (!is_null($item->process_id))
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Process:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ optional($item->process)->name }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                @endif
                                                <!-- /.col-lg-6 -->
                                                @if (!is_null($item->process_segment_id))
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">P. Segment:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ optional($item->processSegment)->name }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                @endif
                                                <!-- /.col-lg-6 -->
                                                @if (!is_null($item->team_id))
                                                <!-- /.col-lg-6 -->
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-5"><label class="bold">Team:</label></div>
                                                        <!-- /.col-5 -->
                                                        <div class="col-7">{{ optional($item->teams)->name }}</div>
                                                        <!-- /.col-7 -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                @endif
                                                <!-- /.col-lg-6 -->
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="kt-portlet__body">
            <div class="row">
                <div class="col-xl-3"></div>
                <div class="col-xl-6">
                    <div class="kt-timeline-v1 kt-timeline-v1--justified">
                        <div class="kt-timeline-v1__items">
                            <div class="kt-timeline-v1__marker"></div>
                            @foreach ($journeys as $item)
                            <div class="kt-timeline-v1__item kt-timeline-v1__item--first">
                                <div class="kt-timeline-v1__item-circle">
                                    <div class="kt-bg-danger"></div>
                                </div>

                                <div class="kt-timeline-v1__item-content">
                                    <div class="kt-timeline-v1__item-title">
                                        History
                                        <span class="float-right">{{ $item->created_at }}</span>
                                    </div>
                                    <div class="kt-timeline-v1__item-body">
                                        <div class="row">

                                            @if (!is_null($item->employer_id))
                                                <!-- /.col-lg-6 -->
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-5"><label class="bold">Employee ID:</label></div>
                                                            <!-- /.col-5 -->
                                                            <div class="col-7">{{ $item->employer_id }}</div>
                                                            <!-- /.col-7 -->
                                                        </div>
                                                        <!-- /.row -->
                                                    </div>
                                            @endif

                                            @if (!is_null($item->process_id))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Process:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->process->name}}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->process_segment_id))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Process Segment:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->processSegment->name }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->designation_id))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Designation:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->designation->name }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->job_role_id))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Job Role:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->jobRole->name }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->department_id))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Department:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->department->name }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->employment_type_id))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Employment Type:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->employmentType->type }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->employee_status_id))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Employee Status:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->employeeStatus->status }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->sup1))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Supervisor 1:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->supervisor1->FullName }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->sup2))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Supervisor 2:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->supervisor2->FullName }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->hod))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-6"><label class="bold">Head of Department:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-6">{{ $item->headOfDepartment->FullName }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->doj))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Joining Date:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->doj }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->contract_start_date))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Contract Start:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->contract_start_date }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->contract_end_date))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Contract End:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->contract_end_date }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->process_doj))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Process DOJ:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->Process_doj }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->process_lwd))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Process LWD:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->Process_lwd }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->probation_start_date))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Probation Start:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->probation_start_date }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->probation_period))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Probation Period:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->probation_period }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->probation_remarks))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Probation Remarks:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->probation_remarks }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif


                                            @if (!is_null($item->permanent_doj))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">Permanent DOJ:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->permanent_doj }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif

                                            @if (!is_null($item->new_role_doj))
                                            <!-- /.col-lg-6 -->
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-5"><label class="bold">New Role DOJ:</label></div>
                                                    <!-- /.col-5 -->
                                                    <div class="col-7">{{ $item->new_role_doj }}</div>
                                                    <!-- /.col-7 -->
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            @endif
                                            <!-- /.col-lg-6 -->
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endforeach


                        </div>
                    </div>
                </div>
                <div class="col-xl-3"></div>
            </div>
        </div> --}}
    </div>
</div>
@endsection

@push('css')
<link href="{{ asset('assets/vendors/general/select2/dist/css/select2.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js')
<script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/select2/dist/js/select2.full.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/owl.carousel/dist/owl.carousel.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-select.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
@endpush




