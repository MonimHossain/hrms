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
                            Manage Employee Status
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form" action="{{route('settings.manage.process.employee.status.update', ['id' => $employeeStatas->id])}}" method="POST">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group ">
                            {{-- <label>Add New Employee</label> --}}
                            <div class="input-group">
                                <input name="_method" type="hidden" value="PUT">
                                <input type="hidden" name="fld_id" value="{{$employeeStatas->id}}">
                                <input type="text" class="form-control" value="{{$employeeStatas->status}}" placeholder="Add New Employee Status" name="status">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                <!--end::Form-->

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
                                    @foreach ($employeeStatases as $status)
                                        <tr>
                                            <th scope="row">{{ $status->id }}</th>
                                            <td>{{ $status->status }}</td>
                                            <td>
                                                <a href="{{route('settings.manage.process.employee.status.edit', ['id' => $status->id])}}" class="editor_edit"><i class="flaticon-edit"></i></a> &nbsp;|&nbsp;
                                                <a href="#" redirect="settings.manage.employee.status" modelName="EmployeeStatus" id="{{ $status->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
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
