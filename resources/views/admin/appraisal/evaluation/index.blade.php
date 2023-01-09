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
                                Evaluation Log
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('evaluation.log.list') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Choose Year</label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control year-pick" readonly required placeholder="" name="year"
                                                   value=""/>
                                            <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Select Evaluation</label>
                                        <div class="form-group">
                                            <select name="evaluationName" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach($evaluations as $evaluation)
                                                    <option value="{{ $evaluation->id }}">{{ $evaluation->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Select Team</label>
                                        <div class="form-group">
                                            <select name="team" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach($teams as $team)
                                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

{{--                                    <div class="col-md-3">--}}
{{--                                        <label>Select Employee</label>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <select name="evaluationName" class="form-control kt-selectpicker" id="" data-live-search="true">--}}
{{--                                                <option value="">Select</option>--}}
{{--                                                @foreach($teams as $team)--}}
{{--                                                    <option value="{{ $team->id }}">{{ $team->name }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                                    <div class="col-xl-1">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0" width="100%" id="lookup">
                                    <thead>
                                    <tr>
                                        <th>Evaluation</th>
                                        <th>Employee Id</th>
                                        <th>Score</th>
                                        <th>Grade</th>
                                        <th>Evaluation Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($employeeEvaluations as $value)
                                            <tr>
                                                <td>
                                                    <p>{{ $value->evaluationName->name }}</p>
                                                    <p class="text-small">Start Date : {{ \Carbon\Carbon::parse($value->evaluationName->start_date)->format('d M, Y') }}</p>
                                                    <p class="text-small">End Date : {{ \Carbon\Carbon::parse($value->evaluationName->end_date)->format('d M, Y') }}</p>
                                                </td>
                                                <td>
                                                    <strong>Name:</strong>
                                                    <a target="_blank" href="http://hrms.test/employee/profile/16">
                                                        {{ $value->createdBy->FullName }}
                                                    </a> <br>
                                                    <strong>EID:</strong> {{ $value->createdBy->employer_id }} <br>
                                                    <strong>Dept:</strong>
                                                    @foreach($value->createdBy->departmentProcess->unique('department_id') as $item)
                                                        {{ $item->department->name ?? null }}@if(!$loop->last && $item->department) , @endif
                                                    @endforeach<br>
                                                </td>
                                                <td>

                                                    <?php
                                                    $result = 0;
                                                    ?>
                                                    @foreach($value->evaluationList as $item)
                                                        <?php
                                                        $array = json_decode($item->ans_value, true);
                                                        $result += array_sum(array_keys($array));
                                                        ?>
                                                    @endforeach
                                                    {{ $result  }}
                                                </td>
                                                <td>
                                                    @foreach($value->evaluationList->groupBy('evaluation_mst') as $item)
                                                        {{ \App\Http\Controllers\Admin\Appraisal\AppraisalControllers::calculateGrade((($result ?? 0) * 100) / ($item->sum('qst_mark') ?? 0))  }}
                                                    @endforeach
                                                </td>
                                                <td class="text-small">
                                                    <p>Created By - {{ $value->createdBy->FullName }} at {{ \Carbon\Carbon::parse($value->createdBy->created_at)->format('d M, Y') }}</p>
                                                    <hr>
                                                    <p>Updated By - {{ $value->updatedBy->FullName }} at {{ \Carbon\Carbon::parse($value->updatedBy->created_at)->format('d M, Y') }}</p>
                                                </td>
                                            </tr>
                                    @endforeach
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
        // enable clear button
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




