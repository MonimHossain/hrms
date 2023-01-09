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
                            Manage Letter and Document
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form" action="{{ route('settings.manage.document.create') }}" method="POST">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group ">
                            {{-- <label>Add New Employee</label> --}}
                            <div class="input-group">
                                <input type="text" class="form-control col-md-4" placeholder="Add New Document" name="name">
                                <input type="text" class="form-control col-md-4" placeholder="Add Reference Number Prefix" name="prefix">

                                <select name="permission" id="" class="form-control col-md-4">
                                    <option value="">Select option</option>
                                    <option value="1">Employee</option>
                                    <option value="2">Admin</option>
                                </select>

                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">ADD</button>
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
                                        <th>Prefix</th>
                                        <th>Permission</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($documents as $document)
                                        <tr>
                                            <th scope="row">{{ $document->id }}</th>
                                            <td>{{ $document->name }}</td>
                                            <td>{{ $document->prefix }}</td>
                                            <td>{{ ($document->permission == 1)? "Employee":"Admin" }}</td>
                                            <td>
                                                <a href="{{route('settings.manage.document.edit', ['id' => $document->id])}}" class="editor_edit"><i class="flaticon-edit"></i></a> &nbsp;|&nbsp;
                                                <a href="#" redirect="settings.manage.document" modelName="DocSetup" id="{{ $document->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
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
