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
                                Details Log
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">


                            <form class="kt-form" action="{{ route('user.hr.appraisal.list') }}" method="GET">
                                <div class="row">

                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Year</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control year-pick" readonly required placeholder="" name="year"
                                                       value=""/>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-calendar-check-o"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Employee</label>
                                            <div class="input-group">
                                                <select name="employee_id" class="form-control kt-selectpicker" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->employee_id }}">{{ $employee->employee->employer_id }} - {{ $employee->employee->FullName }}</option>
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

                                <div class="tab-pane fade show active" id="history" role="tabpanel" aria-labelledby="history-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table table-nowrap mb-0" width="100%" id="">
                                            <thead>
                                            <tr>
                                                <th>Appraisal Year</th>
                                                <th>Employee</th>
                                                <th>Department</th>
                                                <th>Score</th>
                                                <th>Created At</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($appraisalList as $value)
                                                <tr>
                                                    <td>{{ $value->parent->year }}</td>
                                                    <td>{{ $value->employee->employer_id }} - {{ $value->employee->Fullname }}</td>
                                                    <td>
                                                        @foreach($value->employee->departmentProcess->unique('department_id') as $item)
                                                            {{ $item->department->name ?? null }}@if(!$loop->last && $item->department) , @endif
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $value->score }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($value->created_at)->format('d M, Y') }}</td>
                                                    <td>{{ ucwords($value->approved_status) }}</td>
                                                    <td>
                                                        <a href="" style="position: relative; top: 5px" title="Hr Approval"Save form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('user.hr.appraisal.recommend', ['id'=>$value->id]) }}" class="text-primary custom-btn globalModal">
                                                            <span class="btn btn-outline-primary">Show Recommendation</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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




