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
                            Manage Process
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form" action="{{route('settings.manage.process.update', ['id' => $process->id])}}" method="POST">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group ">
                            {{-- <label>Add New Process</label> --}}
{{--                            <div class="input-group">--}}
{{--                                <input name="_method" type="hidden" value="PUT">--}}
{{--                                <input type="hidden" name="fld_id" value="{{$process->id}}">--}}
{{--                                <input type="text" class="form-control" value="{{$process->name}}" placeholder="Add New Process" name="name">--}}
{{--                                <div class="input-group-append">--}}
{{--                                    <button class="btn btn-primary" type="submit">Update</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="row">
                                {{-- <div class="col-6">
                                    <div class="input-group">
                                        <select name="process_id" id="" class="form-control">
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $item)
                                                <option {{ ($process->department_id == $item->id) ? 'selected' : '' }} value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-6">
                                    <div class="input-group">
{{--                                        <input type="text" class="form-control" placeholder="Add New Process" name="name">--}}
                                        <input name="_method" type="hidden" value="PUT">
                                        <input type="hidden" name="fld_id" value="{{$process->id}}">
                                        <input type="text" class="form-control" value="{{$process->name}}" placeholder="Add New Process" name="name">
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
                    <div class="kt-section">
                        <div class="kt-section__content">
                            <table class="table table-striped table-hover" id="lookup">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Process</th>
                                        <th>Department</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($processes as $process)
                                        <tr>
                                            <th scope="row">{{ $process->id }}</th>
                                            <td>{{ $process->name }}</td>
                                            {{-- <td>{{ $process->department->name }}</td> --}}
                                            <td>
                                                <!--begin::Timeline 1-->
                                                <div class="kt-list-timeline">
                                                    <div class="kt-list-timeline__items">
                                                        @foreach($process->department as $department)

                                                            <div class="kt-list-timeline__item" style="width: auto;">
                                                                <span class="kt-list-timeline__badge"></span>
                                                                <span class="kt-list-timeline__text" style="padding: 0 0 0 15px;">{{ $department->name }}</span>

                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                                <!--end::Timeline 1-->
                                            </td>
                                            <td>
                                                <a href="{{route('settings.manage.process.edit', ['id' => $process->id])}}" class="editor_edit"><i class="flaticon-edit"></i></a> &nbsp;|&nbsp;
                                                <a href="#" redirect="settings.manage.process" modelName="Process" id="{{ $process->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
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
