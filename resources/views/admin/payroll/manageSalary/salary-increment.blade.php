@extends('layouts.container')


@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-sm-12">
                @if($salary->employee)
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h3 style="float: left;" class="kt-portlet__head-title">
                                            Salary Increment of <span class="text-success bold">{{ $employee->first_name ? $employee->first_name . " " . $employee->last_name : '' }}</span>
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right" method="POST" action="{{ route('manage.salary.increment.submit') }}">
                        @csrf
                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                        <input type="hidden" name="individual_salary_id" value="{{ $salary->id }}">
                        <input type="hidden" name="type" value="{{ $salary->type }}">
                        <div class="kt-portlet__body">
                            <div class="row">
                                @if($salary->type == 0) {{-- if salary type is hourly --}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Last Hourly Rate:</label>
                                            <input class="form-control" type="text" value="{{ $salary->hourly_rate }}" id="last-hourly-rate" name="last_hourly_rate" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Current Hourly Rate:</label>
                                            <input class="form-control" type="text" value="" id="current-hourly-rate" name="current_hourly_rate" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Incremented Hourly Rate:</label>
                                            <input class="form-control" type="text" value="" id="incremented-hourly-rate" name="incremented_hourly_rate" required>
                                        </div>
                                    </div>
                                @elseif($salary->type == 1) {{-- if salary type is fixed --}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Last Gross Salary:</label>
                                            <input class="form-control" type="text" value="{{ $salary->gross_salary }}" id="last-gross-salary" name="last_gross_salary" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Current Gross Salary:</label>
                                            <input class="form-control" type="text" value="" id="current-gross-salary" name="current_gross_salary" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Incremented Amount:</label>
                                            <input class="form-control" type="text" value="" id="incremented-amount" name="incremented_amount" required>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Effective From:</label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control" autocomplete="off" required placeholder="Select date" id="kt_datepicker_3" name="applicable_from"
                                                value="{{ old('applicable_from') }}"/>
                                            <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="la la-calendar-check-o"></i>
                                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit"
                                                class="btn btn-primary pull-right">
                                            <i class="la la-edit"></i>
                                            Increment Amount
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!--end::Form-->                    
                </div>
                <!--end::Portlet-->
                @else
                    <div class="alert alert-success">
                        Unable to access employee information
                    </div>
                @endif
            </div>


        </div>
    </div>
@endsection


@push('css')
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            $(document).on('keyup', '#incremented-amount', function () {
                let lastGross = $('#last-gross-salary').val();
                let currentGross = $('#current-gross-salary').val(Number(parseFloat(lastGross) + parseFloat($(this).val())).toFixed((2)));
                if(isNaN(currentGross.val())){
                    currentGross.val(null)
                }
            });
            $(document).on('keyup', '#incremented-hourly-rate', function () {
                let lastHourly = $('#last-hourly-rate').val();
                let currentHourly = $('#current-hourly-rate').val(Number(parseFloat(lastHourly) + parseFloat($(this).val())).toFixed((2)));
                if(isNaN(currentHourly.val())){
                    currentHourly.val(null)
                }
            });
        })

    </script>
@endpush
