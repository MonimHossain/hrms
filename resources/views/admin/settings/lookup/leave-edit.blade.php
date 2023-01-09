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
                            Leave Manage
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form" action="{{route('settings.manage.set.leave.update', ['id' => $leave->id])}}" method="POST">
                    @csrf
                    <input name="_method" type="hidden" value="PUT">
                    <input type="hidden" name="fld_id" value="{{$leave->id}}">
                    <div class="kt-portlet__body">
                        <div class="form-group ">
                            <div class="row">

                                <div class="col-2">
                                    <div class="input-group">
                                            <label for="">Leave Name</label>
                                        <div class="col-12">
                                            <input type="text" readonly disabled class="form-control" value="{{ $leave->name }}"
                                                name="name">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2">
                                    <div class="input-group">
                                            <label for="">Hourly</label>
                                        <div class="col-12">
                                            <input type="number" class="form-control" value="{{ $leave->hourly_quantity }}" name="hourly_quantity">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group">
                                            <label for="">Contractual</label>
                                        <div class="col-12">
                                            <input type="number" class="form-control" value="{{ $leave->contractual_quantity }}" name="contractual_quantity">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group">
                                            <label for="">Parmanent</label>
                                        <div class="col-12">
                                            <input type="number" class="form-control" value="{{ $leave->parmanent_quantity }}" name="parmanent_quantity">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="input-group">
                                        <label for="">Probation</label>
                                        <div class="col-12">
                                            <input type="number" class="form-control"
                                                value="{{ $leave->probation_quantity }}" name="probation_quantity">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                            <label for="">&nbsp;</label>
                                        <div class="col-12">
                                            <button class="btn btn-primary pull-right" type="submit">Update</button>
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
                                            <th>Name</th>
                                            <th>Hourly Quantity</th>
                                            <th>Contractual Quantity</th>
                                            <th>Parmanent Quantity</th>
                                            <th>Probation Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leaves as $leave)
                                            <tr>
                                                <th scope="row">{{ $leave->id }}</th>
                                                <td>{{ $leave->name }}</td>
                                                <td>{{ $leave->hourly_quantity }}</td>
                                                <td>{{ $leave->contractual_quantity }}</td>
                                                <td>{{ $leave->parmanent_quantity }}</td>
                                                <td>{{ $leave->probation_quantity }}</td>
                                                <td>
                                                    <a href="{{route('settings.manage.set.leave.edit', ['id' => $leave->id])}}" class="editor_edit"><i class="flaticon-edit"></i></a>
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
