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
                            Setup Leave Reason
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form" action="{{ route('settings.manage.leave.reason.update', ['id' => $leaveReason->id]) }}" method="POST">
                    @csrf
                    <input name="_method" type="hidden" value="PUT">
                    <input type="hidden" name="fld_id" value="{{$leaveReason->id}}">
                    <div class="kt-portlet__body">
                    <div class="form-group ">
                            <div class="row">
                                <div class="col-3">
                                    <div class="input-group">
                                        <label for="" class="ml-3">Leave Reason</label>
                                        <div class="col-12">
                                            <input type="text" class="form-control"
                                                placeholder="Add New Leave Reason" name="leave_reason"  value="{{ $leaveReason->leave_reason }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <div class="pull-right">
                                            <button class="btn btn-primary pull-right" type="submit" style="margin-top:25px;">ADD</button>
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
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Leave Reason</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($leaveReasons as $leaveReason)
                                        <tr>
                                            <th scope="row">{{ $leaveReason->id }}</th>
                                            <td>{{ $leaveReason->leave_reason }}</td>
                                            <td>
                                                <a href="{{route('settings.manage.leave.reason.edit', ['id' => $leaveReason->id])}}" class="editor_edit"><i class="flaticon-edit"></i></a>
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
