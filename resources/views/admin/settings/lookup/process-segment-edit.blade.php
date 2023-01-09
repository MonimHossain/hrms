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
                            Manage Process Segment
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form" action="{{route('settings.manage.process.segment.update', ['id' => $process->id])}}" method="POST">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group ">
                            {{-- <label>Add New Process Segment</label> --}}
                            <div class="row">

                                <div class="col-6">
                                    <div class="input-group">
                                        <select name="process_id" id="" class="form-control">
                                            @foreach ($processesList as $row)
                                                <option <?php echo ($row->id == $process->process->id) ? ' selected="selected"' : ''; ?> value="{{$row->id}}">{{$row->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="input-group">
                                        <input name="_method" type="hidden" value="PUT">
                                        <input type="hidden" name="fld_id" value="{{$process->id}}">
                                        <input type="text" class="form-control" value="{{$process->name}}" placeholder="Add New Process Segment"
                                            name="name">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <br/>

                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group">
                                        <div class="pull-right">
                                            <button class="btn btn-primary pull-right" type="submit">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                </form>
                <!--end::Form-->

                {{-- All Role view table --}}
                <div class="kt-portlet__body">

                    <!--begin::Section-->
                    <div class="kt-section">
                        <div class="kt-section__content">
                            <table class="table table-striped table-hover" id="lookup">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Process Name</th>
                                        <th>Segment Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($processSegments as $process)
                                        <tr>
                                            <th scope="row">{{ $process->id }}</th>
                                            <td>{{ $process->process->name }}</td>
                                            <td>{{ $process->name }}</td>
                                            <td>
                                                <a href="{{route('settings.manage.process.segment.edit', ['id' => $process->id])}}" class="editor_edit"><i class="flaticon-edit"></i></a> &nbsp;|&nbsp;
                                                <a href="#" redirect="settings.manage.process.segment" modelName="ProcessSegment" id="{{ $process->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
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
