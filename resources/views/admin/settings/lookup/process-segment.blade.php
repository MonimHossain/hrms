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
                <form class="kt-form" action="{{ route('settings.manage.process.segment.create') }}" method="POST" id="kt_form">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group ">
                            {{-- <label>Add New Process Segment</label> --}}
                            <div class="row">

                                <div class="col-6">
                                    <div class="input-group">
                                        <select name="process_id" id="" class="form-control">
                                            <option disabled value="">Select Process</option>
                                            @foreach ($processes as $process)
                                            <option value="{{$process->id}}">{{$process->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="input-group">
                                        <div class="col-12">
                                            <input type="text" class="form-control"
                                                placeholder="Add New Process Segment" name="name">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <br/>

                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group">
                                        <div class="pull-right">
                                            <button class="btn btn-primary pull-right" type="submit">ADD</button>
                                        </div>
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



@push('js')
    <script>
    $(document).ready(function () {
        $("#kt_form").validate({
            // rules: {
            //     "name": {
            //         required: true,
            //         minlength: 3
            //     }
            // },
            messages: {
                "name": {
                    required: "Please, enter a name"
                }
            },
            submitHandler: function (form) { // for demo

                return TRUE; // for demo
            }
        });

    });

    </script>
@endpush

@include('layouts.lookup-setup-delete')
