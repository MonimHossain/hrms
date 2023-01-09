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
                               Upload CSV Adjustment
                            </h3>
                        </div>
                        <div class="float-right"><span class="float-right" style="margin-top: 5px;"><a href="{{ asset('hrmsDocs/csv/sample_adjustment.csv') }}">Adjustment Format Download&nbsp;<i aria-hidden="true" class="fa fa-download" style="font-family: &quot;Font Awesome 5 Free&quot;, Bangla823, sans-serif;"></i></a></span></div>
                        <!--
                        <a href="#" style="position: absolute; top: 15px; right: 15px;" title="Upload Mobile bill" form-size="modal-lg" data-toggle="modal" data-target="#kt_modal" action="{{ route('mobilebill.adjustment.form') }}" class="card-text custom-btn globalModal pull-right">
                            <span class="btn btn-outline-primary">Add New</span>
                        </a>
                        <a href="#" style="position: absolute; top: 15px; right: 100px;" title="Mobile bill default settings" form-size="modal-lg" data-toggle="modal" data-target="#kt_modal" action="{{ route('mobilebill.adjustment.settings') }}" class="card-text custom-btn globalModal pull-right">
                            <span class="btn btn-outline-primary">Settings</span>
                        </a> -->
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                        <form class="kt-form kt-form--label-right" method="POST"
                            action="{{ route('mobilebill.adjustment.insert') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="kt-portlet__body">

                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="">File</label>
                                        <div class="custom-file">
                                            <input type="file" name="excel_file" class="form-control" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="">Adjustment Category</label>
                                        <div class="custom-file">
                                            <select name="adjustment_type" class="form-control kt-selectpicker" required id="" data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach($adjustmentType as  $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="">Type</label>
                                        <div class="custom-file">
                                            <select name="type" class="form-control kt-selectpicker" id="" required data-live-search="true">
                                                <option value="">Select</option>
                                                @foreach(\App\Utils\Payroll::ADJUSTMENT['type'] as $key=> $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="">Year-Month </label>
                                        <div class="custom-file">
                                            <input type="text" name="month" class="form-control month-pick" id="month" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <button style="position:relative; top:25px" type="submit" class="btn btn-brand">Upload</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                            <!-- <form class="kt-form" action="{{ route('payroll.adjustment.index')  }}" method="GET">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Month</label>
                                            <div class="input-group date">
                                                <input type="text" autocomplete="off" class="form-control month-pick" name="date_from" placeholder="Select Month" value="{{ Request::get('date_from') }}">
                                                <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group">
                                                <select name="employee_id" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($emoloyees as $employee)
                                                        <option {{ (Request::get('employee_id') ==  $employee->id)? 'selected="selected"':'' }} value="{{ $employee->id }}">{{ $employee->employer_id }}-{{ $employee->FullName }}</option>
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
                            </form> -->

                            <div class="table-responsive">

                            <!-- <table class="table table-striped custom-table table-nowrap mb-0 kt-datatable" width="100%" id="lookup">
                                <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Current Status</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    {{--<th>Remarks</th>--}}
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($adjustments as $adjustment)
                                <tr>
                                    <td>{{ $adjustment->employee->employer_id }}</td>
                                    <td>{{ $adjustment->employee->FullName }}</td>
                                    <td>{{ $adjustment->amount }}</td>
                                    <td>{{ _lang('payroll.adjustment.status', $adjustment->status) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($adjustment->created_at)->format('d M Y') }}</td>
                                    <td>{{ $adjustment->createdBy->FullName }}</td>
                                    {{--<td>{{ str_limit($adjustment->remarks, 20, '...') }}</td>--}}
                                    <td>
                                        @if($confirmation)
                                        <a href="#" title="Update Adjustment" form-size="modal-lg" data-toggle="modal" data-target="#kt_modal" action="{{ route('payroll.adjustment.edit', [$adjustment->id]) }}" class="card-text custom-btn globalModal">
                                            <span class="btn-sm btn-outline-primary"><i class="flaticon-edit"></i></span>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table> -->
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
        $('.month-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy-mm',
            viewMode: 'months',
            minViewMode: 'months'
        });
    </script>
@endpush




