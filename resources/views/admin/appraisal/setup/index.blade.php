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
                                Appraisal Question List
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('appraisal.question.setup.list') }}" method="GET">
                                <div class="row">

                                    <div class="col-xl-5">
                                        <div class="form-group">
                                            <label>Set Name</label>
                                            <div class="input-group">
                                                <select name="name" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($setList as $key=> $row)
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
                                        <th>Question Info</th>
                                        <th>Evaluation</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($setNames as $row)
                                        <tr>
                                            <td>
                                             <p>Division :  {{ $row->division->name ?? '' }}</p>
                                             <p>Center :  {{ $row->center->center ?? '' }}</p>
                                             <p>Department :  {{ $row->department->name ?? '' }}</p>
                                             <p>Process :  {{ $row->process->name ?? '' }}</p>
                                             <p>Process Segment :  {{ $row->processSegment->name ?? '' }}</p>

                                            </td>
                                            <td>
                                                <p><b>Name : {{ $row->evaluationName->name ?? '' }}</b></p>
                                                <p>Start Date : {{ \Carbon\Carbon::parse($row->evaluationName->start_date)->format('d M, Y') }}</p>
                                                <p>End Date : {{ \Carbon\Carbon::parse($row->evaluationName->end_date)->format('d M, Y') }}</p>
                                            </td>
                                            <td>
                                                <a href="{{ route('employee.profile', ['id'=>$row->evaluationName->name]) }}">{{ $row->evaluationName->employee->FullName }}</a>
                                                <p>at {{ $row->created_at->format('d M, Y')   }}</p>
                                            </td>

                                            <td>
                                                <a href="{{ route('appraisal.question.setup.edit', ['id'=>$row->id]) }}" class="btn btn-outline-primary">Edit</a>
                                                {{--<a href="{{ route('appraisal.question.setup.delete', ['id'=>$row->id]) }}" class="btn btn-outline-danger">Delete</a>--}}
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




