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
                                Closing application status
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('admin.clearance.checklist.list')  }}" method="GET">
                                <div class="row">

                                    <div class="col-xl-3">
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

                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <div class="input-group">
                                                <select name="status" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach(\App\Utils\EmployeeClosing::ApprovedFrom['teamLeadSupervisor'] as $key=> $row)
                                                        <option value="{{ $row }}">{{ _lang('employee-closing.teamLeadSupervisorStatus', $row) }}</option>
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
                                @if(count($list) > 0)
                                <a href="{{ route('admin.clearance.checklist.export') }}"><span class="btn btn-outline-primary">Export</span></a>
                                <table class="table table-striped custom-table table-nowrap mb-0" width="100%" id="lookup">
                                    <thead>
                                    <tr>
                                        <th style="width: 20px !important;">#</th>
                                        <th>Employee</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th>Created At</th>
                                        <th>Final Status</th>
                                        <th>Application Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $row)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $row->employee->employer_id ?? '' }} : {{ $row->employee->FullName ?? '' }}</td>
                                        <td>{{ $row->employee->employeeJourney->designation->name }}</td>
                                        <td>
                                            @foreach($row->employee->departmentProcess as $item)
                                                {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                            @endforeach
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</td>
                                        <td>
                                            {{ _lang('employee-closing.finalStatus', $row->final_closing) }}
                                        </td>
                                        <td>
                                            {{ _lang('employee-closing.teamLeadSupervisorStatus', $row->status) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                    {{ $list->appends(Request::all())->links() }}
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
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
@endpush






