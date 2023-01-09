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
                                Leave Balance Update
                            </h3>
                        </div>
                    </div>


                    <!--begin::Form-->
                    <div class="container">
                        <div class="row">
                            <div class="offset-sm-1 col-sm-9">

                                <div class="kt-portlet__body">
                                    <form action="{{ route('admin.leave.balance.update') }}" method="get">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-sm-4">
                                                <label>Select Employee:</label>
                                                <select id="employee_id" name="employee_id"
                                                        class="form-control kt-selectpicker " data-live-search="true"
                                                        data-placeholder="{{ ($employee) ? $employee->fullName : 'Select Employee' }}">
                                                </select>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <div class="kt-form__actions">
                                                        <button type="submit" name="submit"
                                                                class="btn btn-outline-primary"
                                                                style="margin-top: 25px">Search
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--                                            <div class="col-sm-3"><div class="form-group"><div class="kt-form__actions"><button type="submit" class="btn btn-outline-primary" style="margin-top: 25px">Apply wild leave</button></div></div></div>--}}
                                        </div>
                                    </form>
                                </div>


                                <hr class="col-sm-12">
                                <br>

                                @if($employee)
                                    <h5>Update leave balance for : <span class="text-info">{{ $employee->employer_id }} - {{ $employee->FullName }}</span>
                                    </h5>

                                    <div class="kt-section dtHorizontalExampleWrapper ">

                                    </div>
                                    <form class="kt-form kt-form--label-right" id="leaveApplication"
                                          novalidate="novalidate"
                                          action="{{ route('admin.leave.balance.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                        <div class="kt-portlet__body">

                                            <table class="table table-bordered table-hover">
                                                <tr class="text-center">
                                                    <th>Leave type</th>
                                                    <th>Total</th>
                                                    <th>Used</th>
                                                </tr>
                                                @foreach($leaveBalances as $item)
{{--                                                    {{ dd($leaveBalances) }}--}}
                                                    @if($item->leave_type_id != \App\Utils\LeaveStatus::MATERNITY && $item->leave_type_id != \App\Utils\LeaveStatus::PATERNITY)
                                                        <?php
                                                           $earnLeaveService = new App\Services\EarnLeaveService($employee);
                                                        ?>
                                                        <tr>
                                                            <td>{{ $item->leaveType->leave_type }}</td>
                                                            <td>
{{--                                                                @if(($item->leave_type_id != \App\Utils\LeaveStatus::LWP))--}}
{{--                                                                    @if(($item->leave_type_id == \App\Utils\LeaveStatus::EARNED))--}}
{{--                                                                        <input class="form-control" type="number" value="{{ str_replace('.0', '', number_format( $earnLeaveService->calculateEarnLeaveBalance() , 1, '.', '')) }}" name="total[{{$item->leave_type_id}}]">--}}
{{--                                                                    @else--}}
{{--                                                                        <input class="form-control" type="number" value="{{ $item->total }}" name="total[{{$item->leave_type_id}}]">--}}
{{--                                                                    @endif--}}
{{--                                                                @endif--}}
                                                                @if(($item->leave_type_id != \App\Utils\LeaveStatus::LWP))
                                                                    @if($item->leave_type_id == \App\Utils\LeaveStatus::CASUAL)
                                                                        <input class="form-control" type="number" value="{{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}" name="total[{{$item->leave_type_id}}]">
                                                                    @elseif($item->leave_type_id == \App\Utils\LeaveStatus::SICK)
                                                                        <input class="form-control" type="number" value="{{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}" name="total[{{$item->leave_type_id}}]">
                                                                    @else
                                                                        <input class="form-control" type="number" value="{{ str_replace('.0', '', number_format( $item->total , 1, '.', '')) }}" name="total[{{$item->leave_type_id}}]">
                                                                    @endif                                                                    
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(($item->leave_type_id == \App\Utils\LeaveStatus::EARNED))
                                                                    <input class="form-control" type="number" value="{{ str_replace('.0', '', number_format( $item->used , 1, '.', '')) }}" name="used[{{$item->leave_type_id}}]">
                                                                @else
                                                                    <input class="form-control" type="number" value="{{ str_replace('.0', '', number_format( $item->used , 1, '.', '')) }}" name="used[{{$item->leave_type_id}}]">
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </table>
                                        </div>

                                        <div class="kt-portlet__foot">
                                            <div class="kt-form__actions">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <button type="submit"
                                                                class="btn btn-outline-primary">Update
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>


                                @else
                                    <div class="form-group form-group-last">
                                        <div class="alert alert-outline-warning fade show" role="alert"
                                             id="kt_form_1_msg">
                                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                            <div class="alert-text">
                                                Search for employee first.
                                            </div>
                                            <div class="alert-close">
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                    <span aria-hidden="true"><i class="la la-close"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>

                <!--end::Form-->

            </div>
            <!--end::Portlet-->
        </div>
    </div>
    {{--    </div>--}}
@endsection

@push('css')
    {{--    <link href="{{ asset('assets/vendors/general/select2/dist/css/select2.css') }}" rel="stylesheet" type="text/css"/>--}}
    <style>
        .inner-table {
            border-collapse: collapse;
            border-spacing: 0px;
            text-align: center;
            font-size: 10px;
            font-weight: 500;
            vertical-align: middle;
            border-width: .5px;
            border-style: solid;
        }

        .inner-table th {
            border: 1px solid #0abb87;
        }

        .inner-table td {
            border: 1px solid #0abb87;
        }
    </style>
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>

    <script src="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/sweetalert2.init.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/select2/dist/js/select2.full.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>

    <script>

        function addSelect2Ajax($element, $url, $changeCallback, data) {
            var placeHolder = $($element).data('placeholder');

            if (typeof $changeCallback == 'function') {
                $($element).change($changeCallback)
            }

            // $($element).hasClass('select2') && $($element).select2('destroy');

            return $($element).select2({
                allowClear: true,
                width: "resolve",
                ...data,
                placeholder: placeHolder,
                ajax: {
                    url: $url,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        }
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (obj, index) {
                                return {id: obj.id, text: obj.name};
                            })
                        };
                    }
                }
            });

        }

        addSelect2Ajax('#employee_id', "{{route('employee.all')}}");
    </script>

    <script>
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
    </script>
@endpush
