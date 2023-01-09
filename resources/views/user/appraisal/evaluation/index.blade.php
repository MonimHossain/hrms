@extends('layouts.container')

@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    @php

                    $text = ['p'=>'Pending', 'a'=>'Accepted', 'r'=>'Rejected'];
                    $color = ['p'=> 'text-warning', 'a'=>'text-success', 'r'=>'text-danger'];

                    @endphp

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
                                            <h3 class="kt-portlet__head-title">{{ $runningEvaluation->name ?? '' }}</h3>
                                        </div>
                                        <div class="kt-portlet__head-toolbar">
                                            <div class="kt-portlet__head-actions">
                                                <a href="#" style="width: 110px;" title="Create My Evaluation" form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('user.my.evaluation.create', ['id'=>$runningEvaluation->id]) }}" class="btn btn-outline-light btn-sm btn-icon btn-icon-md custom-btn globalModal">
                                                    <i class="flaticon2-add-1"></i>
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

                            <form class="kt-form" action="{{ route('user.my.evaluation.list') }}" method="GET">
                                <div class="row">

                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Year</label>
                                            <div class="input-group date"><input type="text" readonly="readonly"
                                                                                 required="required" placeholder=""
                                                                                 name="year" value=""
                                                                                 class="form-control year-pick">
                                                <div class="input-group-append"><span class="input-group-text"><i
                                                            class="la la-calendar-check-o"></i></span></div>
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
                                                        <option value="{{ $row->id }}">{{ ucwords($row->name ?? '') }}</option>
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
                                        <th>Score</th>
                                        <th>Status</th>
                                        <th>Updated By</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($finalData as $list)
                                            @if(!empty($list))
                                                <tr>
                                                <td>
                                                    <p>{{ $list['name'] }}</p>
                                                    <p>Start: {{ \Carbon\Carbon::parse($list['start'])->format('d M, Y') }}</p>
                                                    <p>End  : {{ \Carbon\Carbon::parse($list['end'])->format('d M, Y')  }}</p>
                                                </td>
                                                <td>
                                                    <p>Score : {{ $list['sum'] }} out of {{ $list['total'] }}</p>
                                                </td>
                                                <td>
                                                    <span class="{{ $color[$list['status']] }}">{{ $text[$list['status']] }}</span>
                                                    (<span class="text-small">{{ $list['updated_at'] }}</span>)
                                                </td>
                                                <td class="text-small">
                                                    <p>Created By - {{ $list['created_by'] ?? '' .' at '. $list['created_at'] }}</p>
                                                    <hr>
                                                    <p>Updated By - {{ $list['updated_by'] ?? '' .' at '. $list['updated_at'] }}</p>
                                                </td>
                                                <td>
                                                    <?php if(in_array($list['status'], ['p', 'r']) || $list['lead_id'] == null){ ?>
                                                    <a href="{{ route('user.my.evaluation.accept.reject', ['employeeId'=>$list['employeeId'], 'evaluationId'=> $list['evaluationId'], 'flag'=>'a']) }}"><span class="btn btn-outline-primary">Accept</span></a>
                                                    <a href="{{ route('user.my.evaluation.accept.reject', ['employeeId'=>$list['employeeId'], 'evaluationId'=> $list['evaluationId'], 'flag'=>'r']) }}"><span class="btn btn-outline-danger">Reject</span></a>
                                                    <?php }?>
                                                    <a href="" title="View My Evaluation"Save form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('user.my.evaluation.view', ['employeeId'=>$list['employeeId'], 'evaluationId'=> $list['evaluationId']]) }}" class="text-primary custom-btn globalModal">
                                                        <span class="btn btn-outline-primary">View</span>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endif
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




