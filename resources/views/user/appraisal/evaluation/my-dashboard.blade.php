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
                              My Evaluation Summary
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">


                            <form class="kt-form" action="{{ route('user.my.evaluation.dashboard') }}" method="GET">
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
                                        <th>Year</th>
                                        <th>Score</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                @if(!empty($finalData))
                                    @foreach($finalData as $list)

                                        <tr>
                                            <td> {{ \Carbon\Carbon::parse($list['id'])->format('Y') }}</td>
                                            <td>
                                                <p>Score : {{ number_format(($list['sum'] *100)/ $list['total'], 2) }} out of {{ '100' }}</p>
                                            </td>
                                            <td>
                                                <?php if($list['status'] == 'p'){ ?>
                                                <a href="{{ route('user.my.evaluation.accept.reject', ['employeeId'=>$list['employeeId'], 'evaluationId'=> $list['evaluationId'], 'flag'=>'a']) }}"><span class="btn btn-outline-primary">Accept</span></a>
                                                <a href="{{ route('user.my.evaluation.accept.reject', ['employeeId'=>$list['employeeId'], 'evaluationId'=> $list['evaluationId'], 'flag'=>'r']) }}"><span class="btn btn-outline-danger">Reject</span></a>
                                                <?php }?>
                                                <a href="{{ route('user.my.evaluation.list', ['year'=>$list['id']]) }}" class="text-primary">
                                                    <span class="btn btn-outline-primary">View</span>
                                                </a>
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




