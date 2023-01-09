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
                <form class="kt-form" action="{{ route('settings.manage.center.create') }}" method="POST">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-4">
                                    <div class="input-group">
                                        <select name="division_id" id="" class="form-control" required>
                                            <option value="">Select Division</option>                                            
                                            @foreach ($divisions as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Short Name" name="center">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Full Name" name="name">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">ADD</button>
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
                    <div class="kt-section">
                        <div class="kt-section__content">
                            <table class="table table-striped table-hover" id="lookup">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Division</th>
                                        <th>Center (short)</th>
                                        <th>Center (full)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- {{ dd($centers) }} --}}
                                    @foreach ($centers as $center)
                                        <tr>
                                            <th scope="row">{{ $center->id }}</th>
                                            <td>{{ $center->division ? $center->division->name : '' }}</td>
                                            <td>{{ $center->center }}</td>
                                            <td>{{ $center->name }}</td>
                                            <td>
                                                <a href="#" title="Add Department To Center" data-toggle="modal" data-target="#kt_modal"
                                                   action="{{ route('settings.manage.center.add.department', ['id'=>$center->id]) }}"
                                                   class="custom-btn globalModal" class="btn btn-outline-primary">
                                                    <i class="flaticon-cogwheel-2"></i>
                                                </a> |
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
