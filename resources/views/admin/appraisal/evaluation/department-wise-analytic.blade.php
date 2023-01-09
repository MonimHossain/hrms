@extends('layouts.container')

@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Employee Evaluation Analytical Report
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="" method="GET">
                                <div class="row">

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Year</label>
                                            <div class="input-group date"><input type="text" readonly="readonly"
                                                                                 required="required" placeholder=""
                                                                                 name="year" value="{{ Request::get('year') }}"
                                                                                 class="form-control year-pick">
                                                <div class="input-group-append"><span class="input-group-text"><i
                                                            class="la la-calendar-check-o"></i></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Evaluation</label>
                                            <div class="input-group">
                                                <select name="evaluation" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($evaluationList as $key=> $row)
                                                        <option value="{{ $row->id }}" {{ (Request::get('evaluation') == $row->id)? 'selected="selected"':'' }}>{{ ucwords($row->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <div class="input-group">
                                                <select name="department" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">All</option>
                                                    @foreach($departments as $key=> $department)
                                                        <option value="{{ $department->id }}" {{ (Request::get('department') == $department->id)? 'selected="selected"':'' }}>{{ ucwords($department->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    {{--<div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Team</label>
                                            <div class="input-group">
                                                <select name="team" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($teams as $key=> $team)
                                                        <option value="{{ $team->id }}" {{ (Request::get('team') == $team->id)? 'selected="selected"':'' }}>{{ ucwords($team->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Employee</label>
                                            <div class="input-group">
                                                <select name="employee" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($employees as $key=> $employee)
                                                        <option value="{{ $employee->employer_id }}" {{ (Request::get('employee') == $employee->employer_id)? 'selected="selected"':'' }}>{{ $employee->employer_id }} - {{ ucwords($employee->FullName) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>--}}

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @if(Request::get('year'))
                                <span class="kt-badge kt-badge--primary margin-right-10  kt-badge--inline kt-badge--pill"><strong>Year</strong>: {{ Request::get('year') }}</span>
                            @endif
                            @if(Request::get('evaluation'))
                                <span class="kt-badge kt-badge--primary margin-right-10  kt-badge--inline kt-badge--pill"><strong>Evaluation</strong>: {{ \App\AppraisalEvaluationName::find(Request::get('evaluation'))->name ?? '' }}</span>
                            @endif
                            @if(Request::get('department'))
                                @php
                                    $department = \App\Department::find(Request::get('department'));
                                @endphp
                                <span class="kt-badge kt-badge--primary margin-right-10  kt-badge--inline kt-badge--pill"><strong>Department</strong>: {{ $department->name ?? '' }}</span>
                            @else
                                <span class="kt-badge kt-badge--primary margin-right-10  kt-badge--inline kt-badge--pill"><strong>Department</strong>: {{ 'All' }}</span>
                            @endif

                            <div class="table-responsive">

                                <table class="table table-striped custom-table" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Department</th>
                                        @for($i=1; $i<= count(_lang('recommendation-for.status')); $i++)
                                            <th>{{  _lang('recommendation-for.status.'.$i) }}</th>
                                        @endfor
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!isset($departmentId))
                                        @foreach($departments as $department)
                                            @if(array_key_exists($department->id, $finalData))
                                            <tr>
                                                <td>{{ $department->name }}</td>
                                                @for($i=1, $j=0; $i <= count(_lang('recommendation-for.status')); $i++, $j++)
                                                    <td>
                                                        @if(isset($finalData[$department->id][$i]))
                                                        <a href="" style="font-weight: bold; font-size: 16px;" title="Employee View" form-size="modal-xl" data-toggle="modal"  data-target="#kt_modal"
                                                           action="{{ route('evaluation.analytic.employee.view', ['year'=> Request::get('year') ?? 0, 'evaluation'=>Request::get('evaluation') ?? 0, 'department'=> $department->id, 'recommend'=> $i]) }}"
                                                           class="text-primary custom-btn globalModal">
                                                        {{ $finalData[$department->id][$i]}}
                                                        </a>
                                                        @else
                                                            {{ '0' }}
                                                        @endif
                                                    </td>
                                                @endfor
                                            </tr>
                                            @else
                                            <tr>
                                                <td>{{ $department->name }}</td>
                                                @for($i=1; $i <= count(_lang('recommendation-for.status')); $i++)
                                                    {{--<td>{{ $finalData[$department->id][$i] ?? 0 }}</td>--}}
                                                    <td>0</td>
                                                @endfor
                                            </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>{{ $department->name }}</td>
                                            @for($i=1, $j=0; $i <= count(_lang('recommendation-for.status')); $i++, $j++)
                                                <td>
                                                    @if(isset($finalData[$departmentId][$i]))
                                                        <a href="" style="font-weight: bold; font-size: 16px;" title="Employee View" form-size="modal-xl" data-toggle="modal"  data-target="#kt_modal"
                                                           action="{{ route('evaluation.analytic.employee.view', ['year'=> Request::get('year') ?? 0, 'evaluation'=>Request::get('evaluation') ?? 0, 'department'=> $department->id, 'recommend'=> $i]) }}"
                                                           class="text-primary custom-btn globalModal">
                                                            {{ $finalData[$departmentId][$i]}}
                                                        </a>
                                                    @else
                                                        {{ '0' }}
                                                    @endif
                                                </td>
                                            @endfor
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection


@push('css')
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
    {{-- attendance css --}}
    <link href="{{ asset('assets/css/attendance.css') }}" rel="stylesheet">

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript"></script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>

    <script !src="">
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


        /*Date Picker*/
        $('.year-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy',
            viewMode: 'years',
            minViewMode: 'years'
        });



    </script>
@endpush




