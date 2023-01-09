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
                                Generate Leave Balance
                            </h3>
                        </div>
                    </div>


                    <!--begin::Form-->
                    <div class="container">
                        <div class="row">
                            <div class="offset-sm-1 col-sm-9">

                                <div class="kt-portlet__body">
                                    <form action="{{ route('admin.leave.application') }}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-sm-4">
                                                <label>Select Employee:</label>
                                                <select id="employee_id" name="employee_id" class="form-control kt-selectpicker " data-live-search="true"
                                                        data-placeholder="Select Employee">
                                                </select>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <div class="kt-form__actions">
                                                        <button type="submit" name="submit" value="apply_wild_leave" class="btn btn-outline-primary" style="margin-top: 25px">
                                                            Apply leave (Admin)
                                                        </button>
                                                        <button type="submit" name="submit" value="generate_leave_balance" class="btn btn-outline-primary" style="margin-top: 25px">
                                                        Generate Leave Balance
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

                                @if($employee_id && $leaveTypes && $request_type == 'apply_wild_leave')
                                    <h5>Apply Leave for <span class="text-info">{{ $employee->employer_id }} - {{ $employee->FullName }}</span></h5>

                                    <div class="kt-section dtHorizontalExampleWrapper ">
                                        <table class="inner-table" id="html_table" width="100%">
                                            <thead>
                                            <tr>
                                                @if($balances->count() > 0)
                                                    @foreach($balances as $balance)
                                                        @if($balance->leave_type_id != App\Utils\LeaveStatus::MATERNITY && $balance->leave_type_id != App\Utils\LeaveStatus::PATERNITY && $balance->leave_type_id != App\Utils\LeaveStatus::LWP)
                                                        <th colspan="3">{{ _lang('leave.leaveType',$balance->leave_type_id)  }}</th>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <th>Please Generate Leave Balance First</th>
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <tr>
                                                @if($balances->count() > 0)
                                                    @php
                                                        $earnLeaveService = new \App\Services\EarnLeaveService($employee);
                                                    @endphp
                                                    @foreach($balances as $balance)
                                                        @if($balance->leave_type_id == App\Utils\LeaveStatus::CASUAL)
                                                            <td>Total : {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}</td>
                                                            <td>Used : {{ str_replace('.0', '',$balance->used) }}</td>
                                                            <td>Remain : {{ str_replace('.0', '',$earnLeaveService->proratedCasualLeaveRemain()) }}</td>
                                                        @endif
                                                        @if($balance->leave_type_id == App\Utils\LeaveStatus::SICK)
                                                            <td>Total : {{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}</td>
                                                            <td>Used : {{ str_replace('.0', '',$balance->used) }}</td>
                                                            <td>Remain : {{ str_replace('.0', '',$earnLeaveService->proratedSickLeaveRemain()) }}</td>
                                                        @endif
                                                        @if($balance->leave_type_id == App\Utils\LeaveStatus::EARNED)
                                                            <?php
                                                                $earnLeaveService = new App\Services\EarnLeaveService($employee);
                                                            ?>
                                                            <td>Total : {{ str_replace('.0', '', number_format( $balance->total + $earnLeaveService->calculateEarnLeaveBalance() , 1, '.', '')) }}</td>
                                                            <td>Used : {{ str_replace('.0', '',$balance->used) }}</td>
                                                            <td>Remain : {{ str_replace('.0', '', number_format(($balance->total + $earnLeaveService->calculateEarnLeaveBalance() - $balance->used) , 1, '.', '')) }}</td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </tr>
                                            </tbody>
                                        </table>
                                        <br>

                                    </div>
                                    <form class="kt-form kt-form--label-right" id="leaveApplication" novalidate="novalidate"
                                          action="{{ route('admin.employee.leave.apply') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        {{--                                        <h5>Apply Leave for <span class="text-info">{{ $employee->employer_id }} - {{ $employee->FullName }}</span></h5>--}}
                                        <input type="hidden" name="employee_id" value="{{ $employee_id }}">

                                        <div class="kt-portlet__body">
                                            <div class="form-group form-group-last kt-hide">
                                                <div class="alert alert-outline-danger fade show" role="alert" id="kt_form_1_msg">
                                                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                    <div class="alert-text">
                                                        Oh snap! Change a few things up and try submitting again.
                                                    </div>
                                                    <div class="alert-close">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true"><i class="la la-close"></i></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-3">
                                                    <label>Leave Type</label>
                                                    <select class="form-control" name="leave_type_id" id="leave_type">
                                                        <option value="">Select Type</option>
                                                        @foreach ($leaveTypes as $leaveType)
                                                            <option
                                                                value="{{ $leaveType->leave_type_id }}">{{ _lang('leave.leaveType',$leaveType->leave_type_id) }}</option>
                                                        @endforeach
                                                        <option
                                                            value="{{ \App\Utils\LeaveStatus::LWP }}">{{ _lang('leave.leaveType', \App\Utils\LeaveStatus::LWP) }}</option>
                                                    </select>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>Start Date:</label>
                                                    <input type="text" value="" name="start_date"
                                                           class="form-control kt_datepicker_3 start-date " readonly
                                                           placeholder="Select Start Date">
                                                </div>

                                                <div class="col-sm-3">
                                                    <label class="">End Date:</label>
                                                    <input type="text" name="end_date" readonly
                                                           class="form-control kt_datepicker_3 end-date" placeholder="Select End Date">
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>If Half Day*</label>
                                                    <select class="form-control" name="half_day" id="half_day" disabled>
                                                        <option value="">Select Half Day</option>
                                                        <option value="{{ \App\Utils\LeaveStatus::FIRST_HALF_DAY }}">First Half</option>
                                                        <option value="{{ \App\Utils\LeaveStatus::SECOND_HALF_DAY }}">Second Half</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                {{-- <div class="col-lg-6">
                                                    <label class="">Subject</label>
                                                    <input type="text" name="subject" class="form-control"
                                                           id="subject" placeholder="Enter Subject">
                                                </div> --}}
                                                <div class="col-lg-6">
                                                    <label class="">Leave Reason</label>
                                                    <select class="form-control" name="leave_reason_id" required>
                                                        <option value="">Select </option>
                                                        @foreach ($leaveReasons as $leaveReason)
                                                        <option value="{{ $leaveReason->id }}">{{ $leaveReason->leave_reason }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-lg-6">
                                                    <label class="">Address During leave:</label>
                                                    <div class="kt-input-icon kt-input-icon--right">
                                                    <textarea name="leave_location" id="address" class="form-control" rows="1"
                                                              placeholder="Address During leave"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <label class="">Remarks:</label>
                                                    <textarea name="description" id="description" cols="30"
                                                              rows="3" class="form-control"
                                                              placeholder="Leave Remarks."></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                {{-- <div class="col-lg-8">
                                                    <label class="">Address During leave:</label>
                                                    <div class="kt-input-icon kt-input-icon--right">
                                                    <textarea name="leave_location" id="address" class="form-control" rows="1"
                                                              placeholder="Address During leave"></textarea>
                                                    </div>
                                                </div> --}}


                                                {{-- <div class="col-lg-4">
                                                    <label class="">Resume Date:</label>
                                                    <div class="kt-input-icon kt-input-icon--right">
                                                        <input name="resume_date" type="text" readonly
                                                               class="form-control kt_datepicker_3" placeholder="Select Resume Date">
                                                    </div>
                                                </div> --}}
                                                <div class="col-lg-8 col-md-8 col-sm-12">
                                                <label class="">Leave Documents</label>
                                                {{--                                                <div class="kt-dropzone dropzone m-dropzone--success" action="{{ route('user.leave.document.upload') }}" id="dropzone">--}}
                                                {{--                                                    <div class="kt-dropzone__msg dz-message needsclick">--}}
                                                {{--                                                        <h3 class="kt-dropzone__msg-title">Drop files here or click to upload.</h3>--}}
                                                {{--                                                        <span class="kt-dropzone__msg-desc">Only image, pdf and psd files are allowed for upload</span>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}
                                                <div class="file-upload">
                                                    <div class="file-select">
                                                        <div class="file-select-button" id="fileName">Choose File</div>
                                                        <div class="file-select-name" id="noFile">No file chosen...</div>
                                                        <input type="file" name="file" id="chooseFile">
                                                        <div id="output"></div>
                                                    </div>
                                                </div>

                                            </div>

                                            </div>
                                        </div>

                                        <div class="kt-portlet__foot">
                                            <div class="kt-form__actions">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <button type="submit"
                                                                class="btn btn-outline-primary">Submit
                                                        </button>
                                                        <button type="button" class="btn btn-outline-secondary">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                @elseif($employee_id && $leaveBalanceSettings && $request_type == 'generate_leave_balance')
                                    <h5>Custom leave generate for <span class="text-info">{{ $employee->employer_id }} - {{ $employee->FullName }}</span></h5>
                                    <div class="kt-section dtHorizontalExampleWrapper ">
                                        <table class="inner-table" id="html_table" width="100%">
                                            <thead>
                                            <tr>
                                                @if($balances->count() > 0)
                                                    @foreach($balances as $balance)
                                                        <th colspan="3">{{ _lang('leave.leaveType',$balance->leave_type_id)  }}</th>
                                                    @endforeach
                                                @else
                                                    <th>Please Generate Leave Balance First</th>
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <tr>
                                                @if($balances->count() > 0)
                                                    @php
                                                        $earnLeaveService = new \App\Services\EarnLeaveService($employee);
                                                    @endphp
                                                    @foreach($balances as $balance)
                                                        @if($balance->leave_type_id == App\Utils\LeaveStatus::CASUAL)
                                                            <td>Total : {{ str_replace('.0', '', $earnLeaveService->proratedCasualLeave()) }}</td>
                                                            <td>Used : {{ str_replace('.0', '',$balance->used) }}</td>
                                                            <td>Remain : {{ str_replace('.0', '',$balance->remain) }}</td>
                                                        @endif
                                                        @if($balance->leave_type_id == App\Utils\LeaveStatus::SICK)
                                                            <td>Total : {{ str_replace('.0', '', $earnLeaveService->proratedSickLeave()) }}</td>
                                                            <td>Used : {{ str_replace('.0', '',$balance->used) }}</td>
                                                            <td>Remain : {{ str_replace('.0', '',$balance->remain) }}</td>
                                                        @endif
                                                        @if($balance->leave_type_id == App\Utils\LeaveStatus::EARNED)
                                                            <td>Total : {{ str_replace('.0', '',$balance->total) }}</td>
                                                            <td>Used : {{ str_replace('.0', '',$balance->used) }}</td>
                                                            <td>Remain : {{ str_replace('.0', '',$balance->remain) }}</td>
                                                        @endif
                                                        @if($balance->leave_type_id == App\Utils\LeaveStatus::MATERNITY)
                                                            <td>Total : {{ str_replace('.0', '',$balance->total) }}</td>
                                                            <td>Used : {{ str_replace('.0', '',$balance->used) }}</td>
                                                            <td>Remain : {{ str_replace('.0', '',$balance->remain) }}</td>
                                                        @endif
                                                        @if($balance->leave_type_id == App\Utils\LeaveStatus::PATERNITY)
                                                            <td>Total : {{ str_replace('.0', '',$balance->total) }}</td>
                                                            <td>Used : {{ str_replace('.0', '',$balance->used) }}</td>
                                                            <td>Remain : {{ str_replace('.0', '',$balance->remain) }}</td>
                                                        @endif
                                                        @if($balance->leave_type_id == App\Utils\LeaveStatus::LWP)
                                                            <td>Total : {{ str_replace('.0', '',$balance->total) }}</td>
                                                            <td>Used : {{ str_replace('.0', '',$balance->used) }}</td>
                                                            <td>Remain : {{ str_replace('.0', '',$balance->remain) }}</td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </tr>
                                            </tbody>
                                        </table>
                                        <br>

                                    </div>

                                    <form class="kt-form kt-form--label-right" id="leaveApplication" novalidate="novalidate"
                                          action="{{ route('admin.employee.custom.leave.generate') }}" method="POST">
                                        @csrf

                                        <input type="hidden" name="employee_id" value="{{ $employee_id }}">

                                        <div class="form-group row">
                                            @if($leaveBalanceSettings->where('leave_type_id', \App\Utils\LeaveStatus::CASUAL)->first())
                                                <div class="col-sm-3">
                                                    <label class="">Casual Used Leave:</label>
                                                    <input type="text" name="casual_used"
                                                           class="form-control" placeholder="Ex: 6 (only number)">
                                                </div>
                                            @endif
                                            @if($leaveBalanceSettings->where('leave_type_id', \App\Utils\LeaveStatus::SICK)->first())
                                                <div class="col-sm-3">
                                                    <label class="">Sick Used Leave:</label>
                                                    <input type="text" name="sick_used"
                                                           class="form-control" placeholder="Ex: 3 (only number)">
                                                </div>
                                            @endif
                                            @if($leaveBalanceSettings->where('leave_type_id', \App\Utils\LeaveStatus::MATERNITY)->first())
                                                <div class="col-sm-3">
                                                    <label class="">Maternity Used Leave:</label>
                                                    <input type="text" name="maternity_used"
                                                           class="form-control" placeholder="Ex: 4 (only number)">
                                                </div>
                                            @endif
                                            @if($leaveBalanceSettings->where('leave_type_id', \App\Utils\LeaveStatus::PATERNITY)->first())
                                                <div class="col-sm-3">
                                                    <label class="">Paternity Used Leave:</label>
                                                    <input type="text" name="paternity_used"
                                                           class="form-control" placeholder="Ex: 4 (only number)">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group row">
                                            @if($leaveBalanceSettings->where('leave_type_id', \App\Utils\LeaveStatus::LWP)->first())
                                                <div class="col-sm-3">
                                                    <label class="">Leave Without Pay Used:</label>
                                                    <input type="text" name="lwp_used"
                                                           class="form-control" placeholder="Ex: 4 (only number)">
                                                </div>
                                            @endif
                                            @if($leaveBalanceSettings->where('leave_type_id', \App\Utils\LeaveStatus::EARNED)->first())
                                                <div class="col-sm-3">
                                                    <label class="">Earned Used Leave:</label>
                                                    <input type="text" name="earned_used"
                                                           class="form-control" placeholder="Ex: 4 (only number)">
                                                </div>
                                            @endif
                                            @if($leaveBalanceSettings->where('leave_type_id', \App\Utils\LeaveStatus::EARNED)->first())
                                                <div class="col-sm-3">
                                                    <label class="">Earned Forwarded:</label>
                                                    <input type="text" name="earned_forwarded"
                                                           class="form-control" placeholder="Ex: 12 (only number)">
                                                </div>
                                            @endif
                                            <div class="kt-portlet__foot">
                                                <div class="kt-form__actions">
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <button type="submit"
                                                                    class="btn btn-outline-primary">Generate
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                @else
                                    <div class="form-group form-group-last">
                                        <div class="alert alert-outline-warning fade show" role="alert" id="kt_form_1_msg">
                                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                            <div class="alert-text">
                                                Search for employee first.
                                            </div>
                                            <div class="alert-close">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
    <script src="{{ asset('assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript"></script>
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

    <script>
        $(document).ready(function () {
            // Display a warning toast, with no title
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": false,
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "slideDown",
                "hideMethod": "fadeOut"
            };

            let leave_type = null, start_date = 0, end_date = 0, diff = 0;
            let casual_leave = (_ => _)({{ \App\Utils\LeaveStatus::CASUAL }});
            let earned_leave = (_ => _)({{ \App\Utils\LeaveStatus::EARNED }});
            let sick_leave = (_ => _)({{ \App\Utils\LeaveStatus::SICK }});
            let maternity_leave = (_ => _)({{ \App\Utils\LeaveStatus::MATERNITY }});
            let paternity_leave = (_ => _)({{ \App\Utils\LeaveStatus::PATERNITY }});
            let lwp = (_ => _)({{ \App\Utils\LeaveStatus::LWP }});

            let maternity_leave_quantity = ((_ => _)({{ $maternity_leave }})) ? (_ => _)({{ $maternity_leave }}) / 2 - 1 : null;
            let paternity_leave_quantity = ((_ => _)({{ $paternity_leave }})) ? (_ => _)({{ $paternity_leave }}) / 2 - 1 : null;

            // alert(maternity_leave_quantity);
            $('#leave_type').on('change', function () {
                leave_type = $(this).val(); // get leave type value
                if (start_date != 0 && end_date != 0) {
                    exceptionHandle(leave_type, start_date, end_date)
                }
                if (leave_type && start_date != 0) {
                    dateDiffCheck(leave_type, start_date, end_date);
                    maternityPaternityLeave(leave_type, diff);
                    // paternityLeave(leave_type, diff);
                }
            });

            $('.start-date').datepicker().on('changeDate', function (e) {
                start_date = new Date($(this).val());
                canApply(start_date); // can apply
                if (end_date != 0) {
                    exceptionHandle(leave_type, start_date, end_date)
                }
                if (leave_type && start_date != 0) {
                    dateDiffCheck(leave_type, start_date, end_date);
                    maternityPaternityLeave(leave_type, diff);
                    // paternityLeave(leave_type, diff);
                }
            });

            $('.end-date').datepicker().on('changeDate', function (e) {
                end_date = new Date($(this).val());
                if (start_date != 0) {
                    exceptionHandle(leave_type, start_date, end_date);
                    maternityPaternityLeave(leave_type, diff);
                    // paternityLeave(leave_type, diff);
                }
            });

            //handle all exceptions
            function exceptionHandle(leave_type, start_date, end_date) {
                canApply(start_date); // can apply
                dateDiffCheck(leave_type, start_date, end_date);// calculate leave count
                halfDayEnable(leave_type, diff); // half day validation
                casualLeaveWarning(leave_type, diff); // casual leave warning
                maternityPaternityLeave(leave_type, diff);
            }

            // can apply
            function canApply(start_date) {
                let today = new Date();
                // let diff = new Date(today - start_date);
                let diff = (today - start_date) / (1000 * 60 * 60 * 24) + 1;
                console.log(Math.round(diff))
                // if (Math.round(diff) > 15 ) {
                //     toastr.error("You can not apply for past dated leave more than 15 days.", "Opps!!");
                // }else{
                //     // Remove current toasts using animation
                //     toastr.clear()
                // }
            }

            // calculate leave count
            function dateDiffCheck(leave_type, start_date, end_date) {
                diff = (end_date - start_date) / (1000 * 60 * 60 * 24) + 1; // calculate leave count
                return diff;
            }

            // half day input field enable/disable
            function halfDayEnable(leave_type, diff) {
                if (diff == 1 && (leave_type == casual_leave || leave_type == sick_leave)) {
                    $('#half_day').prop('disabled', false);
                } else {
                    $('#half_day').prop('disabled', true);
                }
            }

            //casual day warning
            function casualLeaveWarning(leave_type, diff) {
                if (diff > 2 && leave_type == casual_leave) {
                    toastr.warning("You should not apply casual leave more than two days. It might not be accepted without appropriate/exception reason.", "Hey!!");
                }
            }

            //maternity leave
            function maternityPaternityLeave(leave_type, diff) {
                if (leave_type == maternity_leave && maternity_leave_quantity > 0) {
                    $('.end-date').prop('readonly', true).datepicker('destroy');
                    var date = new Date(start_date);
                    var newdate = new Date(date);
                    var end_date = newdate.setDate(newdate.getDate() + maternity_leave_quantity);
                    $('.end-date').val(getFormattedDate(end_date));
                } else if (leave_type == paternity_leave && paternity_leave_quantity > 0) {
                    $('.end-date').prop('readonly', true).datepicker('destroy');
                    var date = new Date(start_date);
                    var newdate = new Date(date);
                    var end_date = newdate.setDate(newdate.getDate() + paternity_leave_quantity);
                    $('.end-date').val(getFormattedDate(end_date));
                } else {
                    $('.end-date')
                        .prop('readonly', true)
                        .datepicker({
                            rtl: KTUtil.isRTL(),
                            todayBtn: "linked",
                            clearBtn: true,
                            todayHighlight: true,
                            orientation: "bottom left",
                            templates: arrows,
                            format: 'yyyy-mm-dd',
                        });
                }
            }

            //paternity leave
            // function paternityLeave(leave_type, diff) {
            //     if(leave_type == paternity_leave && paternity_leave_quantity > 0){
            //         $('.end-date').prop('readonly', true).datepicker('destroy');
            //
            //         var date = new Date(start_date);
            //         var newdate = new Date(date);
            //         var end_date = newdate.setDate(newdate.getDate() + paternity_leave_quantity);
            //         $('.end-date').val(getFormattedDate(end_date));
            //
            //     }else{
            //         $('.end-date')
            //             .prop('readonly', true)
            //             .datepicker({
            //                 rtl: KTUtil.isRTL(),
            //                 todayBtn: "linked",
            //                 clearBtn: true,
            //                 todayHighlight: true,
            //                 orientation: "bottom left",
            //                 templates: arrows,
            //                 format: 'yyyy-mm-dd',
            //             });
            //     }
            // }

            //format date
            function getFormattedDate(date) {
                let newDate = new Date(date);
                let year = newDate.getFullYear();
                let month = (1 + newDate.getMonth()).toString().padStart(2, '0');
                let day = newDate.getDate().toString().padStart(2, '0');
                return year + '-' + month + '-' + day;
            }

            // leave form validation
            $("#leaveApplication").validate({
                // define validation rules
                rules: {
                    leave_type_id: {
                        required: true,
                    },
                    start_date: {
                        required: true
                    },
                    end_date: {
                        required: true
                    },
                    subject: {
                        required: true
                    },
                    description: {
                        required: false
                    },
                    leave_location: {
                        required: false
                    },
                    resume_date: {
                        required: true
                    },

                },

                //display error alert on form submit
                invalidHandler: function (event, validator) {
                    var alert = $('#kt_form_1_msg');
                    alert.removeClass('kt--hide').show();
                    KTUtil.scrollTop();
                },

                submitHandler: function (form) {
                    form[0].submit(); // submit the form
                }
            });
        });
    </script>
    <script>
        $('#chooseFile').bind('change', function () {
            var filename = $("#chooseFile").val();
            if (/^\s*$/.test(filename)) {
                $(".file-upload").removeClass('active');
                $("#noFile").text("No file chosen...");
            } else {
                $(".file-upload").addClass('active');
                $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
            }
            console.log($(this).files);

            // loadMime(fileInput.files[0], function(mime) {
            //     //print the output to the screen
            //     output.innerHTML = mime;
            // });
        });
    </script>



    {{--    <script>--}}
    {{--        $(document).ready(function () {--}}
    {{--            $('#kt_repeater_1').repeater({--}}
    {{--                initEmpty: false,--}}

    {{--                defaultValues: {--}}
    {{--                    'text-input': 'foo'--}}
    {{--                },--}}

    {{--                show: function () {--}}
    {{--                    $(this).slideDown();--}}
    {{--                    var arrows;--}}
    {{--                    if (KTUtil.isRTL()) {--}}
    {{--                        arrows = {--}}
    {{--                            leftArrow: '<i class="la la-angle-right"></i>',--}}
    {{--                            rightArrow: '<i class="la la-angle-left"></i>'--}}
    {{--                        }--}}
    {{--                    } else {--}}
    {{--                        arrows = {--}}
    {{--                            leftArrow: '<i class="la la-angle-left"></i>',--}}
    {{--                            rightArrow: '<i class="la la-angle-right"></i>'--}}
    {{--                        }--}}
    {{--                    }--}}
    {{--                    // enable clear button--}}
    {{--                    $('#kt_datepicker_3, #kt_datepicker_3_validate').datepicker({--}}
    {{--                        rtl: KTUtil.isRTL(),--}}
    {{--                        todayBtn: "linked",--}}
    {{--                        clearBtn: true,--}}
    {{--                        todayHighlight: true,--}}
    {{--                        orientation: "bottom left",--}}
    {{--                        templates: arrows,--}}
    {{--                        format: 'yyyy-mm-dd',--}}
    {{--                    });--}}
    {{--                },--}}

    {{--                hide: function (deleteElement) {--}}
    {{--                    $(this).slideUp(deleteElement);--}}
    {{--                },--}}

    {{--            });--}}
    {{--        });--}}

    {{--    </script>--}}



    {{--    <script>--}}
    {{--        $('#kt_sweetalert_demo_3_1').click(function (e) {--}}
    {{--            var startDate = $('input[name$="start_date"]').val();--}}
    {{--            var endDate = $('input[name$="end_date"]').val();--}}
    {{--            var leaveQuantity = $('#quantity').val();--}}
    {{--            var subject = $('#subject').val();--}}
    {{--            var description = $('#description').val();--}}
    {{--            var address = $('#address').val();--}}
    {{--            var resumeDate = $('input[name$="resume_date"]').val();--}}
    {{--            var leaveType = $('#leave_type').val();--}}


    {{--            if (startDate == "") {--}}
    {{--                swal.fire("Whoops!", "Start Date Field is required", "warning");--}}
    {{--                return false;--}}
    {{--            }--}}
    {{--            if (endDate == "") {--}}
    {{--                swal.fire("Whoops!", "End Date Field is required", "warning");--}}
    {{--                return false;--}}
    {{--            }--}}
    {{--            if (leaveQuantity == "") {--}}
    {{--                swal.fire("Whoops!", "Day Count Field is required", "warning");--}}
    {{--                return false;--}}
    {{--            }--}}

    {{--            if (subject == "") {--}}
    {{--                swal.fire("Whoops!", "Subject Field is required", "warning");--}}
    {{--                return false;--}}
    {{--            }--}}

    {{--            if (description == "") {--}}
    {{--                swal.fire("Whoops!", "Description Field is required", "warning");--}}
    {{--                return false;--}}
    {{--            }--}}

    {{--            if (address == "") {--}}
    {{--                swal.fire("Whoops!", "Address Field is required", "warning");--}}
    {{--                return false;--}}
    {{--            }--}}

    {{--            if (resumeDate == "") {--}}
    {{--                swal.fire("Whoops!", "Resume Date Field is required", "warning");--}}
    {{--                return false;--}}
    {{--            }--}}

    {{--            if (leaveType == "") {--}}
    {{--                swal.fire("Whoops!", "Leave Type Field is required", "warning");--}}
    {{--                return false;--}}
    {{--            }--}}

    {{--            $.ajax({--}}
    {{--                url: "{{ route('get.leave.validation.rules') }}",--}}
    {{--                type: 'POST',--}}
    {{--                data: {"_token": "{{ csrf_token() }}", "quantity": leaveQuantity, "type": leaveType},--}}
    {{--                success: function (data) {--}}
    {{--                    if (data == 'yes') {--}}
    {{--                        swal.fire("Success!", "Your Leave Has Been Send!", "success");--}}
    {{--                        $("#leaveApplication").submit();--}}
    {{--                    } else {--}}
    {{--                        swal.fire("Whoops!", "You are not eligible get this number of leave!", "error");--}}
    {{--                    }--}}
    {{--                }--}}
    {{--            });--}}

    {{--        });--}}

    {{--    </script>--}}

@endpush
