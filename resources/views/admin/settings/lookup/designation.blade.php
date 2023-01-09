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
                            Manage Dasignation
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form" action="{{ route('settings.manage.designation.create') }}" method="POST">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group ">
                            {{-- <label>Add New Dasignation</label> --}}
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Add New Dasignation" name="name">
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($designations as $designation)
                                        <tr>
                                            <th scope="row">{{ $designation->id }}</th>
                                            <td>{{ $designation->name }}</td>
                                            <td>
                                                <a href="{{route('settings.manage.designation.edit', ['id' => $designation->id])}}" class="editor_edit"><i class="flaticon-edit"></i></a> &nbsp;|&nbsp;
                                                <a href="#" redirect="settings.manage.designation" modelName="Designation" id="{{ $designation->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
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

