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
                                Team wise Analytic Report
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('user.evaluation.analytical.report.team') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Choose Year</label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control year-pick" readonly required placeholder="" name="year"
                                                   value="{{ Request::get('year') }}"/>
                                            <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-3">
                                        <label>Select Team</label>
                                        <div class="form-group">
                                            <select name="team" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach($teams as $team)
                                                    <option {{ (Request::get('team') == $team->id)?'selected="selected"':'' }} value="{{ $team->id }}">{{ $team->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Select Evaluation</label>
                                        <div class="form-group">
                                            <select name="evaluationName"  class="form-control kt-selectpicker" id="" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach($evaluations as $evaluation)
                                                    <option {{ (Request::get('evaluationName') == $evaluation->id)?'selected="selected"':'' }} value="{{ $evaluation->id }}">{{ $evaluation->name }}</option>
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

                            @if(Request::get('year'))
                            <span class="kt-badge kt-badge--primary margin-right-10  kt-badge--inline kt-badge--pill"><strong>Year</strong>: {{ Request::get('year') }}</span>
                            @endif
                            @if(Request::get('team'))
                                <span class="kt-badge kt-badge--primary margin-right-10  kt-badge--inline kt-badge--pill"><strong>Team</strong>: {{ \App\Team::find(Request::get('team'))->name ?? '' }}</span>
                            @endif
                            @if(Request::get('evaluationName'))
                            <span class="kt-badge kt-badge--primary margin-right-10  kt-badge--inline kt-badge--pill"><strong>Evaluation</strong>: {{ \App\AppraisalEvaluationName::find(Request::get('evaluationName'))->name ?? '' }}</span>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0" width="100%" id="lookup">
                                    <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Evaluation</th>
                                        <th>Score</th>
{{--                                        <th>Grade</th>--}}
                                        <th>Recommendation</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($selectYear) && isset($selectTeam))
                                        @foreach($employeeEvaluations as $value)
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                        @if (isset($value->createdBy->profile_image))

                                                            <img class="img-thumbnail float-left img-fluid" width='50'
                                                                 style="margin-right:10px;"
                                                                 src="{{  asset('storage/employee/img/thumbnail/'.$value->createdBy->profile_image) }}"
                                                                 alt="user-image">
                                                        @elseif(isset($value->createdBy->gender) && $value->createdBy->gender == "Male")
                                                            <img class="img-thumbnail float-left img-fluid" width='50'
                                                                 style="margin-right:10px;"
                                                                 src="{{  asset('assets/media/users/default_male.png') }}"
                                                                 alt="user-image">
                                                        @else
                                                            <img class="img-thumbnail float-left img-fluid" width='50'
                                                                 style="margin-right:10px;"
                                                                 src="{{  asset('assets/media/users/default_female.png') }}"
                                                                 alt="user-image">
                                                        @endif
                                                        </div>
                                                        <div class="row">
                                                            <a href="{{ route('user.evaluation.analytical.report.employee', ['year' => Request::get('year'), 'employee' => $value->createdBy->id]) }}" target="_blank" class="kt-link">{{ $value->createdBy->employer_id }} - {{ $value->createdBy->FullName }}</a>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <p>{{ $value->evaluationName->name }}</p>
                                                        <p class="text-small">Start Date : {{ \Carbon\Carbon::parse($value->evaluationName->start_date)->format('d M, Y') }}</p>
                                                        <p class="text-small">End Date : {{ \Carbon\Carbon::parse($value->evaluationName->end_date)->format('d M, Y') }}</p>
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
                                                        {{ $result }}
                                                    </td>
                                                    {{--<td>
                                                        @foreach($value->evaluationList->groupBy('evaluation_mst') as $item)
                                                            {{ \App\Http\Controllers\Admin\Appraisal\AppraisalControllers::calculateGrade((($result ?? 0) * 100) / ($item->sum('qst_mark') ?? 0))  }}
                                                        @endforeach
                                                    </td>--}}
                                                    <td class="text-small">
                                                        @foreach(json_decode($value->recommendation_for, true) as $recom)
                                                            {!! $loop->iteration.' '._lang('recommendation-for.status.'.$recom).'<br>' !!}

                                                        @endforeach


                                                    </td>
                                                </tr>
                                        @endforeach
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




