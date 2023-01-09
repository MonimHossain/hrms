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
                                FNF Report
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('admin.fnf.report')  }}" method="GET">
                                <div class="row">

                                    <div class="form-group col-md-2"><label>Start Date</label>
                                        <div class="input-group date"><input type="text" readonly="readonly"
                                                                             placeholder="Select date" id="kt_datepicker_3"
                                                                             name="start_date" value="{{ Request::get('start_date') }}" class="form-control">
                                            <div class="input-group-append"><span class="input-group-text"><i
                                                        class="la la-calendar-check-o"></i></span></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2"><label>End Date</label>
                                        <div class="input-group date"><input type="text" readonly="readonly"
                                                                             placeholder="Select date" id="kt_datepicker_3"
                                                                             name="end_date" value="{{ Request::get('end_date') }}" class="form-control">
                                            <div class="input-group-append"><span class="input-group-text"><i
                                                        class="la la-calendar-check-o"></i></span></div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group">
                                                <select name="employee_id" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->id }}">{{ $employee->employer_id }} : {{ $employee->FUllName }}</option>
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

                            <div class="table-responsive" id="lookup">
                                @if(count($list) > 0)
                                <a href="{{ route('admin.fnf.report.export') }}"><span class="btn btn-outline-primary">Export</span></a>
                                <table class="table table-striped custom-table table-nowrap mb-0" width="100%">
                                    <thead>
                                    <tr>
                                        <th style="width: 20px !important;">#</th>
                                        <th>Employee</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th>Created At</th>
                                        <th>PF</th>
                                        <th>Leave</th>
                                        <th>Leave Encashment</th>
                                        <th>Gratuity</th>
                                        <th>Payment Date</th>
                                        <th>Total Amount</th>
                                        <th>Adjustment Amount</th>
                                        <th>Payable Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($list as $row)
                                    @if($row->employee)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $row->employee->employer_id ?? '' }} : {{ $row->employee->FullName ?? '' }}</td>
                                        <td>{{ $row->employee->employeeJourney->designation->name }}</td>
                                        <td>
                                            @foreach($row->employee->departmentProcess as $item)
                                                {{ $item->department->name ?? null }}
                                            @endforeach
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</td>
                                        <td>
                                            {{ $row->pf }}
                                        </td>
                                        <td>
                                            {{ $row->leave }}
                                        </td>
                                        <td>
                                            {{ $row->encashment }}
                                        </td>
                                        <td>
                                            {{ $row->gratuity }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($row->payment_date)->format('d M, Y') }}
                                        </td>
                                        <td>
                                            {{ _lang('employee-closing.payment.'.$row->payment_status) }}
                                        </td>
                                        <td>{{ format_number(($row->pf + $row->encashment + $row->gratuity), 2) }}</td>
                                        <td> {{ $row->adjusment_amount }}</td>
                                        <td> {{ $row->payable_amount }}</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                    {{-- {{ $list->appends(Request::all())->links() }} --}}
                                @else
                                    <p>Not Found !</p>
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


@push('library-js')
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js') }}" type="text/javascript">
    </script>
@endpush

@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('#lookup').DataTable( {
                "scrollX": true
            } );
        } );
    </script>
@endpush






