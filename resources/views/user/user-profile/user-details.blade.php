<!--begin::Accordion-->
<div class="accordion  accordion-toggle-arrow" id="accordionExample4" style="width: 100%;">
    <div class="card">
        <div class="card-header" id="headingOne4">
            <div class="card-title" data-toggle="collapse" data-target="#collapsethree4" aria-expanded="true" aria-controls="collapseOne4">
                <i class="flaticon2-layers-1"></i> Contact Info
            </div>
        </div>
        <div id="collapsethree4" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample4">
            <div class="card-body">
                <div class="card-content">
                    <div class="row">
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Contact Number:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->contact_number ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Corporate Number:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->pool_phone_number ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Alt. Number:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->alt_contact_number ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>

                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Emergency Contact:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->emergency_contact_person ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Emergency Number:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->emergency_contact_person_number ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Rel. with Employee:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->relation_with_employee ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Present Address:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->present_address ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Parmanent Address:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->parmanent_address ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingOne4">
            <div class="card-title" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
                <i class="flaticon2-layers-1"></i> Personal Info
            </div>
        </div>
        <div id="collapseOne4" class="collapse " aria-labelledby="headingOne" data-parent="#accordionExample4">
            <div class="card-body">
                <div class="card-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Name:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Login ID:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->login_id ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Email:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->email }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Gender:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->gender ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Date of Birth:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->date_of_birth ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">NID:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->nid ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Passport:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->passport ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Marital Status:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->marital_status ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Religion:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->religion ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">SSC. Reg:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->ssc_reg_num ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Location:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->nearbyLocation->center->center ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Nearby Location:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->nearbyLocation->nearby ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                    <hr>
                    <div class="row">

                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Father's Name:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->father_name ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Mother's Name:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->mother_name ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Spouse Name:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->spouse_name ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Spouse Birthday:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->spouse_dob ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Child Name 1:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->child1_name ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Child Birthday 1:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->child1_dob ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Child Name 2:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->child2_name ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Child Birthday 2:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->child2_dob ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Child Name 3:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->child3_name ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Child Birthday 3:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->child3_dob ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingfour4">
            <div class="card-title" data-toggle="collapse" data-target="#collapsefour4" aria-expanded="true" aria-controls="collapsefour4">
                <i class="flaticon2-layers-1"></i> Employment Info
            </div>
        </div>
        <div id="collapsefour4" class="collapse" aria-labelledby="headingfour" data-parent="#accordionExample4">
            <div class="card-body">
                <div class="card-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Employee ID:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->employer_id ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        @if ($employee->login_id)
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Login ID:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">{{ $employee->login_id ?? null }}</div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                        @endif


                    @if($employee->departmentProcess)
                        <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Department:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">
                                        @foreach($employee->departmentProcess as $item)
                                            {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                        @endforeach
                                    </div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Process:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">
                                        @foreach($employee->departmentProcess as $item)
                                            {{ $item->process->name ?? null }}@if(!$loop->last) , @endif
                                        @endforeach
                                    </div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Process Segment:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">
                                        @foreach($employee->departmentProcess as $item)
                                            {{ $item->processSegment->name ?? null }}@if(!$loop->last) , @endif
                                        @endforeach
                                    </div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                    @endif

                    <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Designation:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->employeeJourney->designation->name ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Job Role:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->employeeJourney->jobRole->name ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Employment Type:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->employeeJourney->employmentType->type ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Employee Status:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->employeeJourney->employeeStatus->status ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Team Lead: </label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->teamMember()->wherePivot('member_type', \App\Utils\TeamMemberType::MEMBER)->first()->teamLead->FullName ?? null }}
                                </div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Date of Joining:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->employeeJourney->doj ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Contract Start:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->employeeJourney->contract_start_date ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Contract End:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->employeeJourney->contract_end_date ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Process Joining Date:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->employeeJourney->process_doj ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Process LWD:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->employeeJourney->process_lwd ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Permanent DOJ:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->employeeJourney->permanent_doj ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">New Role DOJ:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->employeeJourney->new_role_doj ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
{{--                        <div class="col-lg-6">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-5"><label class="bold">Nearby Location:</label></div>--}}
{{--                                <!-- /.col-5 -->--}}
{{--                                <div class="col-7">{{ $employee->nearbyLocation->nearby ?? null }}</div>--}}
{{--                                <!-- /.col-7 -->--}}
{{--                            </div>--}}
{{--                            <!-- /.row -->--}}
{{--                        </div>--}}
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Division:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->divisionCenters[0]->division->name ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-5"><label class="bold">Center:</label></div>
                                <!-- /.col-5 -->
                                <div class="col-7">{{ $employee->divisionCenters[0]->center->center ?? null }}</div>
                                <!-- /.col-7 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col-lg-6 -->


                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingfive5">
            <div class="card-title" data-toggle="collapse" data-target="#collapsefive5" aria-expanded="true" aria-controls="collapsefive5">
                <i class="flaticon2-layers-1"></i> Academic Info
            </div>
        </div>
        <div id="collapsefive5" class="collapse" aria-labelledby="headingfive" data-parent="#accordionExample4">
            <div class="card-body">
                <div class="card-content">
                    @foreach ($employee->educations as $education)
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Level of Education:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">{{ $education->levelOfEducation->name ?? null }}</div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Institute:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">{{ $education->institute ?? null }}</div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Title of Degree/Exam:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">{{ $education->exam_degree_title ?? null }}</div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Major:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">{{ $education->major ?? null }}</div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Result:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">{{ $education->result ?? null }}</div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Passing Year:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">{{ $education->passing_year ?? null }}</div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-lg-6 -->


                        </div>
                        <!-- /.row -->

                        <div class="col-xl-12">
                            <hr class="">
                        </div>

                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingsix6">
            <div class="card-title" data-toggle="collapse" data-target="#collapsesix6" aria-expanded="true" aria-controls="collapsesix6">
                <i class="flaticon2-layers-1"></i> Training Info
            </div>
        </div>
        <div id="collapsesix6" class="collapse" aria-labelledby="headingsix" data-parent="#accordionExample4">
            <div class="card-body">
                <div class="card-content">
                    @foreach ($employee->trainings as $training)
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Level of Education:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">{{ $training->training_title ?? null }}</div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Country:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">{{ $training->country ?? null }}</div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Topics Covered:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">{{ $training->topics_covered ?? null }}</div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Training Year:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">{{ $training->training_year ?? null }}</div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Institute:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">{{ $training->institute ?? null }}</div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Duration:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">{{ $training->duration ?? null }}</div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-5"><label class="bold">Location:</label></div>
                                    <!-- /.col-5 -->
                                    <div class="col-7">{{ $training->location ?? null }}</div>
                                    <!-- /.col-7 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.col-lg-6 -->

                        </div>
                        <!-- /.row -->

                        <div class="col-xl-12">
                            <hr class="">
                        </div>

                    @endforeach

                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header" id="headingseven7">
            <div class="card-title" data-toggle="collapse" data-target="#collapseseven7" aria-expanded="true" aria-controls="collapseseven7">
                <i class="flaticon2-layers-1"></i> Documents
            </div>
        </div>
        <div id="collapseseven7" class="collapse" aria-labelledby="headingseven" data-parent="#accordionExample4">
            <div class="card-body">
                <div class="card-content">
                    <div class="row p-4">
                        @foreach ($employee->trainings as $training)
                            @if ($training->training_file)
                                <div class="col-lg-2">
                                    <a target="_blank" href="{{ \Storage::url('public/employee/documents/'.$training->training_file) }}"><i
                                            class="fa fa-file"></i> Document {{ $loop->iteration }}</a>
                                </div>
                            @endif
                        @endforeach

                        @foreach ($employee->educations as $edu)
                            @if ($edu->edu_file)
                                <div class="col-lg-2">
                                    <a target="_blank" href="{{ \Storage::url('public/employee/documents/'.$edu->edu_file) }}"><i class="fa fa-file"></i>
                                        Document {{ $loop->iteration }}</a>
                                </div>
                            @endif
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<!--end::Accordion-->
