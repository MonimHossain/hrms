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
                                           Process Salary Summary Report
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form center-division-form" action="{{ route('report.payroll.process.salary.status')  }}" method="get">

                                    <div class="row">
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
                                        <div class="col-xl-3">
                                            <label for="division">Select Employment Type</label>
                                            <select class="form-control division" id="" name="employment_type_id" required>
                                                <option value="">Select Employment Type</option>
                                                @foreach($employmentTypes as $type)
                                                    <option value="{{ $type->id }}">{{ $type->type }}</option>
                                                @endforeach
                                            </select>
                                            @error('division_id')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-xl-2">
                                            <label for="division">Division</label>
                                            <select class="form-control division" id="" name="division_id" required>
                                                <option value="">Select Division</option>
                                                @foreach($divisions as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('division_id')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-xl-2">
                                            <label for="center">Center</label>
                                            <select class="form-control center" id="" name="center_id" required>
                                                <option value="">Select Center</option>
                                            </select>
                                            @error('center_id')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-xl-2">
                                            <label for="department">Department</label>
                                            <select class="form-control department @error('department_id') validated @enderror" id=""
                                                    name="department_id" >
                                                <option value="">Select Department</option>
                                            </select>
                                            @error('department_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-xl-2">
                                            <label for="process">Process</label>
                                            <select class="form-control process @error('process_id') validated @enderror" id="process" name="process_id">
                                                <option value="">Select Process</option>
                                            </select>
                                            @error('process_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-xl-3">
                                            <label for="process">Process Segment</label>
                                            <select class="form-control process-segment @error('process_segment_id') validated @enderror" id="processSegment" name="process_segment_id">
                                                <option value="">Select Process Segment</option>
                                            </select>
                                            @error('process_segment_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                                @if($dataset)
                                <table class="table table-striped table-bordered" id="exportTable">
                                    <thead>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Employee Count</th>
                                        <th>Amount(BDT)</th>
                                    </thead>
                                    <tbody>
                                        @foreach($dataset as $data)
                                        <tr>
                                            <td>{{ $data['Name'] }}</td>
                                            <td>{{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('M Y') }}</td>
                                            <td>{{ $data['employeeCount'] }}</td>
                                            <td>{{ $data['amount'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>

                                    </tr>
                                    </tfoot>

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
    @include('layouts.partials.includes.division-center')
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

        $('.year-pick').datepicker({
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
        $(document).on('change', '#process', function () {
            var id = $(this).val();
            $.ajax({
                url: "{{ route('get.all.segment') }}",
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}", "id": id},
                success: function (data) {
                    $('#processSegment').html(data);
                }

            });
        });
    </script>
    <script>

        jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
            return this.flatten().reduce( function ( a, b ) {
                var x = parseFloat(a) || 0;
                var y = parseFloat($(b).attr('data-order')) || 0;
                return x + y
            }, 0 );
        } );

        $(document).ready(function() {
            var table = $('#exportTable').DataTable({
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
                "searching": true,

                footerCallback: function( tfoot, data, start, end, display ) {
                    var api = this.api();
                    var amountSum = api.column(3, {page:'current'}).data().reduce(function ( a, b ) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);
                    $(api.column(3, {page:'current'}).footer()).html("<b>Total: </b>" + amountSum.toFixed(2));

                    var employeeSum = api.column(2, {page:'current'}).data().reduce(function ( a, b ) {
                        return parseInt(a) + parseInt(b);
                    }, 0);
                    $(api.column(2, {page:'current'}).footer()).html("<b>Total: </b>" + employeeSum);
                }
            });
        });
    </script>

    @endpush
