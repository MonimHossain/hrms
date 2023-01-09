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
                                Own Department Clearance
                            </h3>
                        </div>
                    </div>
                    <br>
                    <div class="kt-portlet__body">
                        <div class="kt-section">

                            <form class="kt-form" action="{{ route('own.department.to.clearance')  }}" method="GET">
                                <div class="row">

                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Employee ID</label>
                                            <div class="input-group">
                                                <select name="employee_id" class="form-control kt-selectpicker" id="" data-live-search="true">
                                                    <option value="">Select</option>
                                                    @foreach($emoloyees as $employee)
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

                            <div class="table-responsive">
                                <table class="table table-striped custom-table table-nowrap mb-0 kt-datatable" width="100%">
                                    <thead>
                                    <tr>
                                        <th style="width: 20px !important;">#</th>
                                        <th>Employee</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(!empty($rowHods))
                                        @foreach($rowHods as $closing)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $closing->employeeByApplication->employee->employer_id }} : {{ $closing->employeeByApplication->employee->FullName }}</td>
                                                <td>{{ $closing->employeeByApplication->employee->employeeJourney->designation->name ?? null }}</td>
                                                <td>
                                                    @foreach($closing->employeeByApplication->employee->departmentProcess as $item)
                                                        {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($closing->created_at)->format('d M Y') }}</td>
                                                <td>
                                                    <a href="#" style="width: 110px;" title="Approval For Closing Employee" form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('own.department.to.clearance.show', ['id'=>$closing->id, 'application_id'=> $closing->closing_applications_id, 'flag'=>'hod']) }}" class="text-primary custom-btn globalModal"><span class="btn-sm btn-outline-primary"><i class="flaticon-edit"></i></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>


                                <table class="table table-striped custom-table table-nowrap mb-0 kt-datatable1" width="100%">
                                    <thead>
                                    <tr>
                                        <th style="width: 20px !important;">#</th>
                                        <th>Employee</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($rowInCharges as $closing)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $closing->employeeByApplication->employee->employer_id }} : {{ $closing->employeeByApplication->employee->FullName }}</td>
                                            <td>{{ $closing->employeeByApplication->employee->employeeJourney->designation->name ?? null }}</td>
                                            <td>
                                                @foreach($closing->employeeByApplication->employee->departmentProcess as $item)
                                                    {{ $item->department->name ?? null }}@if(!$loop->last) , @endif
                                                @endforeach
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($closing->created_at)->format('d M Y') }}</td>
                                            <td>
                                                <a href="#" style="width: 110px;" title="Approval For Closing Employee" form-size="modal-lg" data-toggle="modal"  data-target="#kt_modal" action="{{ route('own.department.to.clearance.show', ['id'=>$closing->id, 'application_id'=> $closing->closing_applications_id, 'flag'=>'in']) }}" class="text-primary custom-btn globalModal"><span class="btn-sm btn-outline-primary"><i class="flaticon-edit"></i></span></a>
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


@push('library-js')
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
@endpush






