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
                            Manage Division
                        </h3>
                    </div>
                </div>

                <!--begin::Form-->
                    <form class="kt-form" action="{{route('settings.manage.division.update', ['id' => $division->id])}}" method="POST">
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Short Name" value="{{$division->name}}" name="name">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <input name="_method" type="hidden" value="PUT">
                                            <input type="hidden" name="fld_id" value="{{$division->id}}">
                                            <input type="text" class="form-control" value="{{$division->full_name}}" placeholder="Full Name" name="full_name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    

                <!--end::Form-->

                <div class="kt-portlet__body">

                    <!--begin::Section-->
                    {{-- <div class="kt-section">
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
                                    @foreach ($divisions as $division)
                                        <tr>
                                            <th scope="row">{{ $division->id }}</th>
                                            <td>{{ $division->name }}</td>
                                            <td>
                                                <a href="{{route('settings.manage.division.edit', ['id' => $division->id])}}" class="editor_edit"><i class="flaticon-edit"></i></a> &nbsp;|&nbsp;
                                                <a href="#" redirect="settings.manage.division" modelName="Division" id="{{ $division->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> --}}

                    <!--end::Section-->

                </div>

            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>
@endsection

@include('layouts.lookup-setup-delete')
