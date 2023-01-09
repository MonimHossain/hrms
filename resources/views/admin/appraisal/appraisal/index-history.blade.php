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
                                Appraisal History
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('appraisal.history.list') }}" method="GET">
                                <div class="row">

                                    <div class="col-md-4">
                                        <label>Choose Year</label>
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

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="true">History</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="addnew-tab" data-toggle="tab" href="#addnew" role="tab" aria-controls="addnew" aria-selected="false">Add New</a>
                                </li>
                                {{--<li class="nav-item">
                                    <a class="nav-link" id="evaluation-status-tab" data-toggle="tab" href="#evaluation-status" role="tab" aria-controls="evaluation-status" aria-selected="false">Evaluation status</a>
                                </li>--}}
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="history" role="tabpanel" aria-labelledby="history-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table table-nowrap mb-0" width="100%" id="">
                                            <thead>
                                            <tr>
                                                <th>Appraisal Year</th>
                                                <th>Department</th>
                                                <th>Appraisal Status</th>
                                                <th>Created At</th>
                                                <th>Appraisal View</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($historyDepartment)
                                                @foreach($historyDepartment as $value)
                                                <tr>
                                                    <td>{{ $value->year }}</td>
                                                    <td>{{ $value->department->name }}</td>
                                                    <td>{{ ucwords($value->status) }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($value->created_at)->format('d M, Y') }}</td>
                                                    <td><a href="{{ route('appraisal.history.detail.log', ['id'=>$value->id]) }}" class="btn-sm btn-outline-primary">Details Log</a></td>
                                                    <td><a href="{{ route('appraisal.regenerate', ['id'=> $value->dept_id, 'year'=>$value->year]) }}" class="btn-sm btn-outline-primary">Re-generate</a></td>
                                                </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="addnew" role="tabpanel" aria-labelledby="addnew-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table table-nowrap mb-0" width="100%" id="">
                                            <thead>
                                            <tr>
                                                <th>Appraisal Year</th>
                                                <th>
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-5">Department</div>
                                                            <div class="col-5">Appraisal Status</div>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    {{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->format('Y') }}
                                                </td>
                                                <td>
                                                    <div class="row">

                                                        @foreach($newDepartments as $value)

                                                            <div class="col-lg-12">
                                                                <div class="row">
                                                                    <div class="col-5"><label class="bold">{{ $value->department->name }}</label></div>
                                                                    <div class="col-5">
                                                                        <i class="text-{{ (in_array($value->id, $existingDepartment))?'success':'danger' }} fa fa-{{ (in_array($value->id, $existingDepartment))?'check':'times' }}"></i>
                                                                        @php
                                                                        if(!in_array($value->id, $existingDepartment)){
                                                                        @endphp
                                                                        <a href="{{ route('appraisal.generate', ['id'=> $value->department->id]) }}" class="btn-sm btn-outline-info">Generate</a>
                                                                        @php
                                                                        }else{
                                                                        echo '<span class="btn-sm btn-outline-info">Generated</span>';
                                                                        }
                                                                        @endphp
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        @endforeach

                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{--<div class="tab-pane fade" id="evaluation-status" role="tabpanel" aria-labelledby="evaluation-status">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table table-nowrap mb-0" width="100%" id="">
                                            <thead>
                                            <tr>
                                                <th>Evaluation</th>
                                                <th>
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-5">Department</div>
                                                            <div class="col-5">Evaluation Status</div>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    {{ $currentEvaluation->name ?? '' }}
                                                </td>
                                                <td>
                                                    <div class="row">

                                                        @foreach($departmentStatus as $key => $status)

                                                            <div class="col-lg-12">
                                                                <div class="row">
                                                                    <div class="col-5"><label class="bold">{{ $key }}</label></div>
                                                                    <div class="col-5">
                                                                        <i class="text-{{ ($status == 'complete')?'success':'danger' }} fa fa-{{ ($status == 'complete')?'check':'times' }}"></i>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        @endforeach

                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>--}}
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




