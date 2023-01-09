@extends('layouts.container')


@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Portlet-->
                <div class="kt-portlet">

                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div>
                                        <h3 style="float: left;" class="kt-portlet__head-title">
                                           Tax Statement : {{ \Carbon\Carbon::parse($year.'-'.$month)->format('M, Y') }}
                                        </h3>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="kt-portlet__body">

                        <form class="kt-form" action="{{ route('payroll.tax.statement') }}" method="get">
                            @csrf
                            <div class="kt-portlet">
                                <div class="kt-portlet__body">
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <div class="form-group">
                                                <label>Month</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" readonly placeholder="Select Month"
                                                           id="month-pick" name="month" value="{{ $month }}" />
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
                                                <label>year</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control" readonly placeholder="Select Year"
                                                           id="year-pick" name="year" value="{{ $year }}" />
                                                    <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <div class="kt-form__actions" style="margin-top: 26px;">
                                                    <input type="submit" class="btn btn-primary" id="view" name="button" value="View">
                                                    <input type="submit" class="btn btn-primary" id="generate" name="button" value="Generate" smg="Do you want to generate tax!">
                                                    <input type="submit" class="btn btn-primary" id="regenerate" name="button" value="Regenerate" smg="Do you want to regenerate tax!">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="form-group">
                               {{-- @if($generate)
                                    <a href="#" route="{{ route('payroll.tax.statement.generate') }}" smg="Do you want to generate tax!" type="submit" class="btn btn-outline-info confirm">Generate</a>
                                @endif

                                @if($regenerate)
                                    <a href="#" route="{{ route('payroll.tax.statement.regenerate') }}" smg="Do you want to regenerate tax!" type="submit" class="btn btn-outline-primary confirm">Regenerate</a>
                                @endif

                                @if($confirmation)
                                    <a href="#" route="{{ route('payroll.tax.statement.clearance') }}" smg="Do you want to give clearance" type="submit" class="btn btn-outline-warning confirm">Clearance</a>
                                @endif--}}
                            </div>
                        </div>


                        <div class="table-responsive">
                            @if($history->isNotEmpty())
                            <a class="btn btn-success" href="{{ route('payroll.tax.fund.download', ['year'=>$year, 'month'=> $month]) }}">Download</a>

                            @can(_permission(\App\Utils\Permissions::TAX_CLEARANCE_VIEW))
                            <a id="clearance" title="Tax Status" data-toggle="modal" data-target="#kt_modal"
                               action="{{ route('payroll.tax.statement.view.clearance', ['year'=>$year, 'month'=> $month]) }}"
                               class="btn btn-success custom-btn globalModal text-white pull-right"> <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                Clearance
                            </a>
                            @endcan

                            <table class="table table-striped custom-table table-nowrap mb-0 kt-datatable" width="100%" id="lookup">
                                <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Month</th>
                                    <th>Amount</th>
                                    <th>Due/Pay</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($history as $row)
                                    <tr>
                                        <td>{{ $row->employee->employer_id }}</td>
                                        <td>{{ $row->employee->FullName }}</td>
                                        <td>
                                            @foreach($row->employee->departmentProcess->unique('department_id') as $item)
                                                {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                            @endforeach

                                            @foreach($row->employee->departmentProcess->unique('department_id') as $item)
                                                {{ $item->process->name ?? null }}@if(!$loop->last) , @endif
                                            @endforeach

                                            @foreach($row->employee->departmentProcess->unique('department_id') as $item)
                                                {{ $item->processSegment->name ?? null }}@if(!$loop->last) , @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $row->employee->employeeJourney->designation->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->month)->format('M, Y') }}</td>
                                        <td>{{ $row->amount }}</td>
                                        <td>{{ _lang('payroll.tax.status.'.$row->status) }}</td>
                                        <td>{{ $row->remarks }}</td>
                                        <td>
                                            <a href="{{ route('payroll.tax.edit', ['id'=>$row->id]) }}"><i class="flaticon-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>

                    </div>

                    <!--begin::Form-->


                    <!--end::Form-->

                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection

@include('layouts.confirmation-alert-smg')


@push('css')
    {{--    <link href="{{ asset('assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        table {
            text-align: center;
        }
    </style>
@endpush

@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endpush

@push('js')
    {{-- <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/dropzone.js') }}" type="text/javascript"></script> --}}
    <script src="{{ asset('assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>

    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function(){
            $('.validationCheck').on('change', function(){
                if($(this).is(":checked")){
                    let id = $(this).attr('id');
                    let url = '{{ route('salary.validation', ['']) }}';
                    $.ajax({url: url + '/' + id, success: function(result){
                            alert(result);
                        }});
                }
            })
        })
    </script>


    <script>
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

        $('#month-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'mm',
            viewMode: 'months',
            minViewMode: 'months'
        });

        $('#year-pick').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            format: 'yyyy',
            viewMode: "years",
            minViewMode: "years"
        });

        //Auto load button enable or disabled
        $('#generate').hide();
        $('#regenerate').hide();
        $('#clearance').hide();

        $(document).ready(function () {
            var month = $('#month-pick').val();
            var year = $('#year-pick').val();
            $.ajax({
                url: "{{ route('payroll.tax.statement.button.enabled.disabled') }}",
                type: 'post',
                data: {"_token": "{{ csrf_token() }}", "month":month, "year":year},
                success: function (data) {
                    (data.generate) ?  $('#generate').show() : $('#generate').hide();
                    (data.regenerate) ?  $('#regenerate').show() : $('#regenerate').hide();
                    (data.confirmation) ?  $('#clearance').show() : $('#clearance').hide();
                }
            });
        });

        $('#month-pick, #year-pick').on('change', function () {
            var month = $('#month-pick').val();
            var year = $('#year-pick').val();
            $.ajax({
                url: "{{ route('payroll.tax.statement.button.enabled.disabled') }}",
                type: 'post',
                data: {"_token": "{{ csrf_token() }}", "month":month, "year":year},
                success: function (data) {
                    (data.generate) ?  $('#generate').show() : $('#generate').hide();
                    (data.regenerate) ?  $('#regenerate').show() : $('#regenerate').hide();
                    (data.confirmation) ?  $('#clearance').show() : $('#clearance').hide();
                }
            });
        });



    </script>

@endpush

