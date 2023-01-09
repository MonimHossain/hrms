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
                            Manage Department
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form" action="{{ route('settings.manage.department.create') }}" method="POST">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="row">
                        <div class="form-group col-md-4">
                             <label>Select HOD</label>
                            <div class="input-group">
                                <select name="own_hod_id" class="form-control kt-select2" id="kt_select2_2" required>
                                    <option value="">Select HOD</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->employer_id }} : {{ $employee->FullName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                             <label>Select In Charge</label>
                            <div class="input-group">
                                <select name="own_in_charge_id" class="form-control kt-select2" id="kt_select2_3" required>
                                    <option value="">Select In Charge</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->employer_id }} : {{ $employee->FullName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                             <label>Department</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Add New Department" name="name">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">ADD</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

                </form>
                <!--end::Form-->

                <?php
                if(isset($flag))
                {
                    dd($flag);
                }

                ?>

                {{-- All Role view table --}}
                <div class="kt-portlet__body">

                    <!--begin::Section-->
                    <div class="kt-section">
                        <div class="kt-section__content">
                            <table class="table table-striped table-hover" id="lookup">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($departments as $department)
                                        <tr>
                                            <th scope="row">{{ $department->id }}</th>
                                            <td>{{ $department->name }}</td>
                                            <td>
                                                <a href="{{route('settings.manage.department.edit', ['id' => $department->id])}}" class="editor_edit"><i class="flaticon-edit"></i></a> &nbsp;|&nbsp;
                                                <a href="#" redirect="settings.manage.department" modelName="Department" id="{{ $department->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!--end::Section-->

                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>
@endsection

@include('layouts.lookup-setup-delete')

@push('js')
    <script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>
@endpush
