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
                                Employee Details
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            @php

                                $text = ['p'=>'Pending', 'a'=>'Accepted', 'r'=>'Rejected'];
                                $color = ['p'=> 'text-warning', 'a'=>'text-success', 'r'=>'text-danger'];

                            @endphp


                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0" width="100%" id="lookup">
                                    <thead>
                                    <tr>
                                        <th>Evaluation Name</th>
                                        <th>Score</th>
                                        <th>Updated By</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($finalData as $list)
                                        <tr>
                                            <td>
                                                <p>{{ $list['name'] }}</p>
                                                <p>Start: {{ \Carbon\Carbon::parse($list['start'])->format('d M, Y') }}</p>
                                                <p>End  : {{ \Carbon\Carbon::parse($list['end'])->format('d M, Y')  }}</p>
                                            </td>
                                            <td>
                                                <p>Score : {{ $list['sum'] }} out of {{ $list['total'] }}</p>
                                            </td>
                                            <td class="text-small">
                                                <p>Created By - {{ $list['created_by'] .' at '. $list['created_at'] }}</p>
                                                <hr>
                                                <p>Updated By - {{ $list['updated_by'] .' at '. $list['updated_at'] }}</p>
                                            </td>
                                            <td>
                                                <?php if(in_array($list['status'], ['p', 'r']) || $list['lead_id'] == null){ ?>
                                                <a href="{{ route('user.my.evaluation.accept.reject', ['employeeId'=>$list['employeeId'], 'evaluationId'=> $list['evaluationId'], 'flag'=>'a']) }}"><span class="btn btn-outline-primary">Accept</span></a>
                                                <a href="{{ route('user.my.evaluation.accept.reject', ['employeeId'=>$list['employeeId'], 'evaluationId'=> $list['evaluationId'], 'flag'=>'r']) }}"><span class="btn btn-outline-danger">Reject</span></a>
                                                <?php }?>

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




