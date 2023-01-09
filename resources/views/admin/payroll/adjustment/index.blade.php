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
                                Adjustment
                            </h3>
                        </div>
                        <!-- <a href="#" style="position: relative; top: 15px" title="Add New Adjustment" form-size="modal-lg" data-toggle="modal" data-target="#kt_modal" action="{{ route('payroll.adjustment.create') }}" class="card-text custom-btn globalModal">
                            <span class="btn btn-outline-primary">Add New</span>
                        </a> -->
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                    <div class="row">
                        <div class="paper col-sm-3">
                                    <div class="card card-stats">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-5 col-md-4">
                                                    <div class="icon-big text-center icon-warning"><i
                                                            class="fas fa-users-cog text-theme-2"></i></div>
                                                </div>
                                                <div class="col-7 col-md-8">
                                                    <div class="numbers"><p class="card-category">Adjustment Addition Employee</p>
                                                        <p class="card-title">{{ (isset($adjustments->groupBy('type')['addition'])) ? $adjustments->groupBy('type')['addition']->count() : 0 }}</p>
                                                        <p></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="paper col-sm-3">
                                    <div class="card card-stats">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-5 col-md-4">
                                                    <div class="icon-big text-center icon-warning"><i
                                                            class="fas fa-money-bill text-theme-2"></i></div>
                                                </div>
                                                <div class="col-7 col-md-8">
                                                    <div class="numbers"><p class="card-category">Adjustment Addition Amount</p>
                                                        <p class="card-title">{{ (isset($adjustments->groupBy('type')['addition']))? $adjustments->groupBy('type')['addition']->sum('amount'):0 }}</p>
                                                        <p></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="paper col-sm-3">
                                    <div class="card card-stats">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-5 col-md-4">
                                                    <div class="icon-big text-center icon-warning"><i
                                                            class="fas fa-users-cog text-theme-2"></i></div>
                                                </div>
                                                <div class="col-7 col-md-8">
                                                    <div class="numbers"><p class="card-category">Adjustment Deduction Employee</p>
                                                        <p class="card-title">{{ (isset($adjustments->groupBy('type')['deduction']))? $adjustments->groupBy('type')['deduction']->count() : 0 }}</p>
                                                        <p></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="paper col-sm-3">
                                    <div class="card card-stats">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-5 col-md-4">
                                                    <div class="icon-big text-center icon-warning"><i
                                                            class="fas fa-money-bill text-theme-2"></i></div>
                                                </div>
                                                <div class="col-7 col-md-8">
                                                    <div class="numbers"><p class="card-category">Adjustment Deduction Amount</p>
                                                        <p class="card-title">{{ (isset($adjustments->groupBy('type')['deduction']))? $adjustments->groupBy('type')['deduction']->sum('amount') : 0 }}</p>
                                                        <p></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>

                            <form class="kt-form" action="{{ route('payroll.adjustment.index')  }}" method="GET">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Month</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control month-pick" name="date_from" placeholder="Select Month" value="{{ Request::get('date_from') }}">
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
                                            <label>Adjustment Type</label>
                                            <div class="input-group">
                                                <select name="adjustment_type" class="form-control kt-selectpicker" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($adjustmentType as  $value)
                                                        <option {{ (Request::get('adjustment_type') ==  $value->id)? 'selected="selected"':'' }} value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
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
                            </form>

                            <div class="table-responsive">
                            @if($adjustments->isNotEmpty())
                            <table class="table table-striped custom-table table-nowrap mb-0 kt-datatable" width="100%" id="lookup">
                                <thead>
                                <tr>
                                    <th style="width: 20px">#</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Adjustment Type</th>
                                    <th>Type -</th>
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
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $adjustment->employee->employer_id ?? '' }}</td>
                                    <td>{{ $adjustment->employee->FullName ?? '' }}</td>
                                    <td>{{ $adjustment->adjustmentType->name ?? '' }}</td>
                                    <td>{{ $adjustment->type ?? '' }}</td>
                                    <td>{{ $adjustment->amount ?? '' }}</td>
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
                            </table>
                            @endif
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




