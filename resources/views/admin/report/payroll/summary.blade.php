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
                                            Summary Report
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('report.payroll.salary.status')  }}" method="get">

                                <div class="row">
                                    {{-- <div class="col-xl-4">
                                        <div class="form-group">
                                            <label>Select Month</label>
                                            <div class="input-group">
                                            <input class="form-control" placeholder="Select month" value="{{ Request::get('month') || '' }}" name="month" type="month">
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Month</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" readonly placeholder="Select Month"
                                                    id="month-pick" name="month" value="{{ $month ?? '' }}" />
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
                                                    id="year-pick" name="year" value="{{ $year ?? '' }}" />
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
                                            <label>&nbsp;</label>
                                            <div class="kt-form__actions">
                                                <button type="submit" class="btn btn-primary ">Filter</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <div class="kt-section__content">
                                @if($summary_report)
                                <table class="table table-striped table-bordered" id="exportTable">
                                    <thead>
                                        <th>Type</th>
                                        <th>Employee Count</th>
                                        <th>Amount(BDT)</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($summary_report as $summary)
                                        <tr>
                                            <td>{{ $summary['type'] }}</td>
                                            <td>{{ $summary['employee_count'] }}</td>
                                            <td>{{ number_format($summary['amount'], 2) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td><b>Total</b></td>
                                            <td><b>{{ array_sum(array_column($summary_report,'employee_count')) }}</b></td>
                                            <td><b>{{ number_format(array_sum(array_column($summary_report,'amount')), 2) }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                                @else
                                    <p>No data found!</p>
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

    <link href="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}"
          rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
          rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

@endpush


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
@endpush


@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
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
        $("#kt_select2_3, #kt_select2_3_validate").select2({placeholder:"Select fields"})
    </script>
    <script>
        $(document).ready(function() {
            $('#exportTable').DataTable( {
                dom: 'Bftiprl',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                    'print'
                ],
                "columnDefs": [
                    {"className": "dt-left", "targets": "_all"}
                ],
                "searching": true
            } );
        } );
    </script>

    @endpush
