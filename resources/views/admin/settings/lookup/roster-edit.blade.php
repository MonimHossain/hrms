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
                            Manage Roster
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form" action="{{route('settings.manage.roster.update', ['id' => $roster->id])}}" method="POST">
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="form-group ">
                            <div class="row">
                                    <input type="hidden" name="fld_id" value="{{$roster->id}}">
                                    <input name="_method" type="hidden" value="PUT">
                                    <div class="col-3">
                                        <label for="start-time">Start Time</label>
                                        <input class="form-control" value="{{ $roster->roster_start }}" id="kt_timepicker_2" readonly placeholder="Select time" type="text" name="start_time" />
                                    </div>
                                    <div class="col-3">
                                        <label for="end-time">End Time</label>
                                        <input id="kt_timepicker_2" value="{{ $roster->roster_end }}" id="end-time" type="text" class="form-control"
                                             name="end_time">
                                    </div>
                                    <div class="col-3">
                                        <label for="end-time">Title</label>
                                        <input type="text" class="form-control" value="{{ $roster->title }}" placeholder="Add New Title" name="title">
                                    </div>
                                    <div class="col-3">

                                        <br>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">ADD</button>
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
                                <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Title</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rosters as $roster)
                                                <tr>
                                                    <th scope="row">{{ $roster->id }}</th>
                                                    <td>{{ $roster->roster_start }}</td>
                                                    <td>{{ $roster->roster_end }}</td>
                                                    <td>{{ $roster->title }}</td>
                                                    <td>
                                                        <a href="{{route('settings.manage.roster.edit', ['id' => $roster->id])}}" class="editor_edit"><i class="flaticon-edit"></i></a> &nbsp;|&nbsp;
                                                        <a class="editor_remove"><i class="flaticon-delete"></i></a>
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
<script src="{{ asset('assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/demo1/pages/crud/forms/widgets/bootstrap-timepicker.js') }}" type="text/javascript"></script>
@endpush
