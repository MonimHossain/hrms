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
                            Manage Center
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form" action="{{route('settings.manage.center.update', ['id' => $center->id])}}" method="POST">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-4">
                                    <div class="input-group">
                                        <select name="division_id" id="" class="form-control" required>
                                            <option value="">Select Division</option>
                                            @foreach ($divisions as $item)
                                                <option {{($center->division_id == $item->id) ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('division_id')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{$center->center}}" placeholder="Short Name" name="center" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group">
                                        <input name="_method" type="hidden" value="PUT">
                                        <input type="hidden" name="fld_id" value="{{$center->id}}">
                                        <input type="text" class="form-control" value="{{$center->name}}" placeholder="Full Name" name="name" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>
                                    </div>
                                    @error('center')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
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
                                    @foreach ($centers as $center)
                                        <tr>
                                            <th scope="row">{{ $center->id }}</th>
                                            <td>{{ $center->center }}</td>
                                            <td>
                                                <a href="{{route('settings.manage.center.edit', ['id' => $center->id])}}" class="editor_edit"><i class="flaticon-edit"></i></a> &nbsp;|&nbsp;
                                                <a href="#" redirect="settings.manage.center" modelName="Center" id="{{ $center->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
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
