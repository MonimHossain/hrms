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
                                My Evaluation List
                            </h3>
                        </div>
                    </div>

                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            @if(empty($alreadyExistEvaluation->evaluation_id))
                                @if(($runningEvaluation->id ?? 0) > 0)
                                    <div class="kt-portlet kt-portlet--skin-solid kt-bg-danger">
                                        <div class="kt-portlet__head kt-portlet__head--noborder">
                                            <div class="kt-portlet__head-label">
                                        <span class="kt-portlet__head-icon">
                                            <i class="flaticon2-graphic"></i>
                                        </span>
                                                <h3 class="kt-portlet__head-title">{{ $runningEvaluation->name }}</h3>
                                            </div>
                                            <div class="kt-portlet__head-toolbar">
                                                <div class="kt-portlet__head-actions">
                                                    <a href="#" style="width: 110px;" title="Create Team Lead Evaluation" form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('user.team.lead.evaluation.create', ['id'=>$runningEvaluation->id]) }}" class="btn btn-outline-light btn-sm btn-icon btn-icon-md custom-btn globalModal">
                                                        Add New
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kt-portlet__body">
                                            <p>Start Date : {{ \Carbon\Carbon::parse($runningEvaluation->start_date)->format('d M, Y') }} To End Date : {{ \Carbon\Carbon::parse($runningEvaluation->end_date)->format('d M, Y') }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <form class="kt-form" action="{{ route('evaluation.list.for.lead.by.user') }}" method="GET">
                                <div class="row">

                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Year</label>
                                            <div class="input-group date"><input type="text" readonly="readonly"
                                                                                 required="required" placeholder=""
                                                                                 name="year" value=""
                                                                                 class="form-control year-pick">
                                                <div class="input-group-append"><span class="input-group-text"><i class="la la-calendar-check-o"></i></span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Evaluation</label>
                                            <div class="input-group">
                                                <select name="evaluation" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($evaluationList as $key=> $row)
                                                        <option value="{{ $row->id }}">{{ ucwords($row->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

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

                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0" width="100%" id="lookup">
                                    <thead>
                                    <tr>
                                        <th>Evaluation Name</th>
                                        <th>Team Lead</th>
                                        <th>Score</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($employeeEvaluationList as $list)

                                        <tr>
                                            <td>
                                                <p>{{ $list->evaluationName->name }}</p>
                                                <p>Start: {{ \Carbon\Carbon::parse($list->evaluationName->start_date)->format('d M, Y') }}</p>
                                                <p>End  : {{ \Carbon\Carbon::parse($list->evaluationName->end_date)->format('d M, Y')  }}</p>
                                            </td>
                                            <td>
                                                {{ $list->teamLead->FullName ?? '' }}
                                            </td>
                                            <td>
                                                <?php
                                                $result = 0;
                                                $gndTotal = 0;
                                                ?>
                                                @if(!$list->evaluationList->isEmpty())
                                                    @foreach($list->evaluationList as $value)

                                                        <?php
                                                        $array = json_decode($value->ans_value, true);
                                                        $result += array_sum(array_keys($array));
                                                        $gndTotal += $value->qst_mark;
                                                        ?>
                                                    @endforeach

                                                    <p>Score : {{ $result }} out of {{ $gndTotal }}</p>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="" title="View Team Lead Evaluation"Save form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('user.lead.evaluation.view', ['employeeId'=>$list->createdBy->id, 'evaluationId'=> $list->evaluationName->id]) }}" class="text-primary custom-btn globalModal">
                                                    <span class="btn btn-outline-primary">View</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                {{ $employeeEvaluationList->links() }}
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




