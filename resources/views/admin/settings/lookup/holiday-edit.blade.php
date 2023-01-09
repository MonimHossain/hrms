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
                            Holidays Edit
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form" action="{{route('settings.manage.holidays.update', ['id' => $holiday->id])}}" method="POST">
                    @csrf
                    <div class="container">
                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="fld_id" value="{{$holiday->id}}">
                        <div class="row margin-top-10">
                            {{-- <div class="input-group col-md-3">
                                <select class="form-control division" id="" name="division_id" required>
                                    <option value="">Select Division</option>
                                    @foreach($divisions as $item)
                                        <option {{ ($holiday->division_id == $item->id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('division_id')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="input-group col-md-3">
                                <select class="form-control center" id="" name="center_id" required>
                                    <option value="">Select Center</option>
                                    @foreach($centers as $item)
                                        <option {{ ($holiday->center_id == $item->id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->center }}</option>
                                    @endforeach
                                </select>
                                @error('center_id')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="input-group col-md-6">
                                <input type="text" class="form-control" placeholder="Title" name="title" value="{{ $holiday->title }}">
                            </div>
                            <div class="input-group col-md-3">
                                <input type="date" class="form-control" name="start_date" value="{{ $holiday->start_date }}">
                            </div>
                            <div class="input-group col-md-3">
                                <input type="date" class="form-control" name="end_date" value="{{ $holiday->end_date }}">
                            </div>
                        </div>
                        <div class="row margin-top-10">

                            <div class="input-group col-md-12 margin-top-10">
                                <textarea name="description" class="form-control" id="" placeholder="Enter details">{{ $holiday->description }}</textarea>
                            </div>
                            <div class="form-group col-md-12 margin-top-10">
                                <label>Religions</label>
                                <div class="checkbox-inline">
                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                        <input type="checkbox" id="checkAll" class=""  value="" name="">
                                        <span></span>All
                                    </label>
                                    @foreach ($religions as $religion)
                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--success">
                                            <input type="checkbox" class="religion-checkbox" {{in_array($religion,json_decode($holiday->religion, true)['religion']) ? "checked" : ''}} value="{{ $religion }}" name="religion[]">
                                            <span></span>{{ $religion }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="input-group col-md-12 margin-top-10">
                                <button class="btn btn-primary" type="submit">Update</button>
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
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Centers</th>
                                        <th>Religions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($holidays as $holiday)
                                        <tr>
                                            <td>{{ $holiday->title }}</td>
                                            <td>{{ $holiday->description }}</td>
                                            <td>{{ $holiday->start_date }}</td>
                                            <td>{{ $holiday->end_date }}</td>
                                            <td>
                                                <div class="kt-list-timeline">
                                                    <div class="kt-list-timeline__items">
                                                        @foreach ($holiday->centers as $center)
                                                            <div class="kt-list-timeline__item" style="width: auto;">
                                                                <span class="kt-list-timeline__badge"></span>
                                                                <span class="kt-list-timeline__text" style="padding: 0px 0px 0px 15px;">{{ $center->division->name }} - {{ $center->center }} </span>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="kt-list-timeline">
                                                    <div class="kt-list-timeline__items">
                                                        @foreach (json_decode($holiday->religion, true)['religion'] as $religion)
                                                            <div class="kt-list-timeline__item" style="width: auto;">
                                                                <span class="kt-list-timeline__badge"></span>
                                                                <span class="kt-list-timeline__text" style="padding: 0px 0px 0px 15px;">{{ $religion }}</span>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#" title="Add Holiday To Center" data-toggle="modal" data-target="#center_holiday" data-holiday-id='{{ $holiday->id }}' class="custom-btn holiday-center">
                                                    <i class="flaticon-cogwheel-2"></i>
                                                </a> |
                                                <a href="{{route('settings.manage.holidays.edit', ['id' => $holiday->id])}}" class="editor_edit"><i class="flaticon-edit"></i></a> &nbsp;|&nbsp;
                                                <a href="#" redirect="settings.manage.holidays" modelName="Holiday" id="{{ $holiday->id }}" class="lookup_remove"><i class="flaticon-delete"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end::Section-->

                    <!-- center holiday Modal -->
                    <div class="modal custom-modal fade" id="center_holiday" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Assign holidays to centers</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="kt-form mt-3" action="{{ route('settings.manage.holidays.center.create') }}"
                                        method="post">
                                        @csrf

                                        <div id='modal-data'></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
</div>
@endsection
@include('layouts.lookup-setup-delete')

@push('js')
    <script>
        $(document).on("click", ".holiday-center", function () {
            var holidayId = $(this).data('holiday-id');
            $("#center_holiday .modal-body #holidayid").val(holidayId);
            $('#modal-data').html('');
            $.ajax({
                type:'POST',
                url:'{{ route("settings.manage.holidays.center.checked") }}',
                data: {holiday_id: holidayId},
                success:function(data){
                    console.log(data);
                    $('#modal-data').html(data);
                }
            });
        });
        $(document).on('change', '#checkAll', function () {
            $(".religion-checkbox").prop('checked', $(this).prop("checked"));
        })
        $(document).on('change', '.religion-checkbox', function () {
            ($('.religion-checkbox:checked').length != $('.religion-checkbox').length) ? $("#checkAll").prop('checked', false) : $("#checkAll").prop('checked', true);
        })
    </script>
@endpush
